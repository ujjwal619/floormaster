<?php

namespace App\FMS\Core\Traits;

use App\FMS\Core\Interfaces\HasMorphInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait GetEntity
 */
trait GetEntity
{
    /**
     * @param string $morphType
     * @param array  $conditions
     *
     * @return Collection
     */
    public function getEntities(string $morphType, array $conditions = []): Collection
    {
        return $this->getEntityQuery($morphType, $conditions)->get();
    }

    /**
     * @param $morphType
     *
     * @return HasMorphInterface
     */
    protected function getEntityClass($morphType): HasMorphInterface
    {
        $morphMap = Relation::morphMap();
        if (!isset($morphMap[$morphType])) {
            throw new NotFoundHttpException();
        }

        return new $morphMap[$morphType]();
    }

    /**
     * @param string $morphType
     * @param array  $conditions
     *
     * @return HasMorphInterface
     */
    protected function getEntity(string $morphType, array $conditions = []): HasMorphInterface
    {
        return $this->getEntityQuery($morphType, $conditions)->first();
    }

    /**
     * @param string $morphType
     * @param array  $conditions
     *
     * @return Builder
     */
    private function getEntityQuery(string $morphType, array $conditions = []): Builder
    {
        return $this->getEntityClass($morphType)->when(count($conditions), function ($entityModel) use ($conditions) {
            return $entityModel->where($conditions);
        });
    }
}
