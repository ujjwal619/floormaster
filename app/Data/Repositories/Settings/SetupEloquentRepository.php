<?php

namespace App\Data\Repositories\Settings;

use App\Data\Entities\Models\Customer\Setting\GeneralSetting;
use App\StartUp\BaseClasses\Repository\BaseRepository;

/**
 * Class TermsEloquentRepository
 * @package App\Data\Repositories\Settings\Terms
 */
class SetupEloquentRepository extends BaseRepository implements SetupRepository
{
    /**
     * @var array
     */
    protected $filterFields = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GeneralSetting::class;
    }
}
