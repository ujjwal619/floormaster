<?php

namespace App\FMS\Filters;

class NotEqualsFilter
{
    /**
     * @param $builder
     * @param $column
     * @param $clause
     * @param $operator
     * @param $search
     * @param mixed $chainOperator
     */
    public function __invoke($builder, $column, $clause, $operator, $search, $chainOperator)
    {
        $builder->$clause(function ($query) use ($column, $clause, $operator, $search, $chainOperator) {
            $additionalClause = 'or'.ucfirst($clause).'Null';
            if (is_callable($column)) {
                $column = $column($query, $clause, $operator, $search, $chainOperator);
            } else {
                $query->$clause($column, $operator, $search, $chainOperator);
            }
            $query->$additionalClause($column);
        });
    }
}
