<?php

namespace App\Data\Entities\Traits;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ModelTrait
 * @package App\Data\Entities\Traits
 */
trait ModelTrait
{
    /**
     *  Model Boot Method
     */
    public static function boot()
    {
        parent::boot();

        static::creating(
            function (Model $model) {
                $model->setAttribute('created_by_id', is_null(currentUser()) ? null : currentUser()->id);
            }
        );

        static::updating(
            function (Model $model) {
                $model->setAttribute('updated_by_id', is_null(currentUser()) ? null : currentUser()->id);
            }
        );

        self::deleting(
            function (Model $model) {
                $model->setAttribute('deleted_by_id', is_null(currentUser()) ? null : currentUser()->id)->save();
            }
        );
    }
}
