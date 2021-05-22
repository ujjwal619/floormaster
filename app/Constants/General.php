<?php

namespace App\Constants;

/**
 * Class General
 * @package App\Constants
 */
class General
{
    const PAGINATE_XSMALL = 5;
    const PAGINATE_SMALL  = 15;
    const PAGINATE_MEDIUM = 25;
    const PAGINATE_LARGE  = 35;
    const PAGINATE_XLARGE = 50;

    /**
     * Product Types
     */
    const MATERIAL = 'material';
    const LABOUR   = 'labour';

    /**
     * Returns the array of all product types.
     *
     * @return array
     */
    public static function getAllProductTypes(): array
    {
        return [
            self::MATERIAL,
            self::LABOUR,
        ];
    }
}
