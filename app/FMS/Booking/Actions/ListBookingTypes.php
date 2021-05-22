<?php

namespace App\FMS\Booking\Actions;

use App\Constants\DBTable;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class ListBookingTypes extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $siteId = $request->get('site_id');

        $bookingTypes = $this->filterSiteByUser($user)
            ->join('tbl_booking_types', 'tbl_booking_types.site_id', 'sites.id')
            ->select(
                'tbl_booking_types.id as id',
                'tbl_booking_types.name as name',
                'tbl_booking_types.numeric_column_headings as numeric_column_headings',
                'tbl_booking_types.default_day_limit as default_day_limit',
                'tbl_booking_types.text_column_heading as text_column_heading',
                'tbl_booking_types.site_id as site_id'
            );
            
            if ($siteId) {
                if ($siteId == 3) {
                    $bookingTypes = $bookingTypes->where('tbl_booking_types.site_id', '<>', 4);
                }
                
                if ($siteId == 4) {
                    $bookingTypes = $bookingTypes->where('tbl_booking_types.site_id', '<>', 3);
                }

                if ($siteId == 3 || $siteId == 4) {
                    $bookingTypes = $bookingTypes->whereIn('tbl_booking_types.site_id', [3,4]);
                } else {
                    $bookingTypes = $bookingTypes->where('tbl_booking_types.site_id', $siteId);
                }                
            } else {
                $sites = $user->getSharedSiteIds();
                $bookingTypes = $bookingTypes->whereIn('tbl_booking_types.site_id', $sites->toArray());   
            }

            // dd($bookingTypes->toSql()); 
            // dd($bookingTypes->get()->unique()->toArray());

            $bookingTypes = $bookingTypes
            ->get()->unique();
            
        return $this->sendSuccessResponse($bookingTypes->toArray());
    }
}
