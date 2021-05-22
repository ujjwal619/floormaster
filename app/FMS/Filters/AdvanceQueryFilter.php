<?php

namespace App\FMS\Filters;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AdvanceQueryFilter
{
    public static $callableOperators = [
        '<>' => NotEqualsFilter::class,
    ];
    /**
     * @var array
     */
    protected $filters = ['filters', 'sort'];

    protected $builder;

    protected $metaFieldColumns = [];

    /**
     * @var Request
     */
    private $request;

    private $filterableColumns;

    private $sortableColumns;

    private $searchableFields;

    /**
     * AdvanceQueryFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $filterableColumns
     *
     * @return $this
     */
    public function setFilterableColumns($filterableColumns)
    {
        $this->filterableColumns = $filterableColumns;

        return $this;
    }

    /**
     * @param $sortableColumns
     *
     * @return $this
     */
    public function setSortableColumns($sortableColumns)
    {
        $this->sortableColumns = $sortableColumns;

        return $this;
    }

    public function setSearchableFields($searchableFields)
    {
        $this->searchableFields = $searchableFields;

        return $this;
    }

    /**
     * Apply the filters to the builder.
     *
     * @param $builder
     *
     * @return Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->request->only($this->filters) as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }

            if ('' !== $value) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        return $this->builder;
    }

    public function sort()
    {
        $sortParams = $this->getSortParam();
        $this->builder->when(count($sortParams), function ($query) use ($sortParams) {
            foreach ($sortParams as $column => $direction) {
                if (starts_with($column, 'App\FMS') && class_exists($column)) {
                    (new $column())($this->builder, $direction);

                    continue;
                }
                $query->orderBy($column, $direction);
            }
        });
    }

    protected function filters($value = null)
    {
        if (null === $value) {
            return $this;
        }

        $filters = is_array($value) ? $value : json_decode(trim($value), true);
        foreach ($filters as $column => $conditions) {
            if (array_key_exists($column, $this->filterableColumns['where'])) {
                $this->applyClause('where', array_get($this->filterableColumns['where'], $column), $conditions);
            } elseif (array_key_exists($column, $this->filterableColumns['having'])) {
                $this->applyClause('having', array_get($this->filterableColumns['having'], $column), $conditions);
            }
        }

        return $this->builder;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @return array
     */
    protected function getSortParam()
    {
        if (!$this->request->has('sort')) {
            return [];
        }
        $fields = explode(',', $this->request->get('sort'));
        $sorting = [];
        foreach ($fields as $field) {
            $column = ltrim($field, '-');
            if (array_key_exists($column, $this->sortableColumns)) {
                $column = $this->sortableColumns[$column];
            } elseif (!in_array($column, $this->sortableColumns, true)
                && !in_array($column, $this->metaFieldColumns, true)) {
                $message = sprintf('Sorting by `%s` column not supported.', $column);
                if (null !== ($alternative = $this->findAlternativeSortableColumn($column))) {
                    $message .= sprintf(' Did you mean `%s` column ?', $alternative);
                }

                throw new InvalidArgumentException($message);
            }
            $sorting[$column] = ('-' === $field[0]) ? 'DESC' : 'ASC';
        }

        return $sorting;
    }

    /**
     * @param $clause
     * @param $column
     * @param $conditions
     *
     * @throws InvalidArgumentException
     */
    private function applyClause($clause, $column, array $conditions)
    {
        $chainOperator = strtolower($this->request->get('chain_operator', 'and'));
        foreach ($conditions as $operator => $search) {
            // @TODO refactor >> polymorphism
            switch ($operator) {
                case 'equals':
                    $operator = '=';

                    break;
                case 'not_equals':
                    $operator = '<>';

                    break;
                case 'starts_with':
                    $operator = 'LIKE';
                    $search .= '%';

                    break;
                case 'ends_with':
                    $operator = 'LIKE';
                    $search = '%'.$search;

                    break;
                case 'contains':
                    $operator = 'LIKE';
                    $search = '%'.$search.'%';

                    break;
                case 'not_contains':
                    $operator = 'NOT LIKE';
                    $search = '%'.$search.'%';

                    break;
                case 'less_than':
                    $operator = '<';

                    break;
                case 'less_than_or_equals':
                    $operator = '<=';

                    break;
                case 'greater_than':
                    $operator = '>';

                    break;
                case 'greater_than_or_equals':
                    $operator = '>=';

                    break;
                case 'range':
                    if (!isset($search['from']) && !isset($search['to'])) {
                        throw new InvalidArgumentException('Range filter without from and to key is not supported');
                    }
                    $operator = 'BETWEEN';
                    $search = [$search['from'], $search['to']];

                    break;
                case 'in':
                    if (!is_array($search)) {
                        $search = [$search];
                    }
                    $clause = 'whereIn';

                    break;
            }
            if ('having' === $clause) {
                $this->builder->$clause($column, $operator, $search, $chainOperator);
            } else {
                $this->builder->where(function ($query) use ($operator, $column, $clause, $search, $chainOperator) {
                    if (array_key_exists($operator, self::$callableOperators)) {
                        resolve(self::$callableOperators[$operator])(
                            $query,
                            $column,
                            $clause,
                            $operator,
                            $search,
                            $chainOperator
                        );
                    } elseif (is_callable($column)) {
                        $column($query, $clause, $operator, $search, $chainOperator);
                    } else {
                        if ('whereIn' === $clause) {
                            $query->$clause($column, $search);
                        } else {
                            $query->$clause($column, $operator, $search, $chainOperator);
                        }
                    }

                    return $query;
                });
            }
        }
    }

    /**
     * Attempts to find a column that is *similar* to the given column.
     *
     * @param string $nonExistentColumnName
     *
     * @return string
     */
    private function findAlternativeSortableColumn($nonExistentColumnName)
    {
        $alternative = null;
        $shortest = null;
        foreach ($this->sortableColumns as $column) {
            if (false !== strpos($column, $nonExistentColumnName)) {
                return $column;
            }
            $lev = levenshtein($nonExistentColumnName, $column);
            if ($lev <= strlen($nonExistentColumnName) / 3 && (null === $alternative || $lev < $shortest)) {
                $alternative = $column;
                $shortest = $lev;
            }
        }

        return $alternative;
    }

    /**
     * @param string|null $keyword
     *
     * @return Builder
     */
    protected function search(string $keyword = null): Builder
    {
        if (!empty($keyword)) {
            $this->builder
                ->where(
                    function (Builder $query) use ($keyword) {
                        foreach ($this->searchableFields as $clause => $fields) {
                            if ('whereRaw' === $clause) {
                                foreach ($fields as $field) {
                                    $query->orWhereRaw($field, '%'.$keyword.'%');
                                }
                            } elseif ('where' === $clause) {
                                foreach ($fields as $field) {
                                    $query->orWhere($field, 'LIKE', '%'.$keyword.'%');
                                }
                            }
                        }
                    }
                );
        }

        return $this->builder;
    }
}
