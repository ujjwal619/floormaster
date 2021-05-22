<?php

namespace App\FMS\Booking\Actions;

use App\Constants\DBTable;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class ListBookings extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $siteId = $request->get('site_id');
        $bookingTypeId = $request->get('booking_type_id');

        $bookings = $this->filterSiteByUser($user)
            ->join('tbl_bookings', 'tbl_bookings.site_id', 'sites.id')
            ->join(DBTable::BOOKING_TYPES, DBTable::BOOKING_TYPES.'.id', DBTable::BOOKINGS.'.booking_type_id')
            ->leftJoin(DBTable::JOBS, DBTable::JOBS.'.job_id', DBTable::BOOKINGS.'.job_id')
            ->leftJoin(DBTable::QUOTES, DBTable::QUOTES.'.quote_id', DBTable::BOOKINGS.'.job_id')
            ->select(
                'tbl_bookings.id as id',
                'tbl_bookings.job_id as job_id',
                'tbl_bookings.date as date',
                'tbl_bookings.customer as customer',
                'tbl_bookings.location as location',
                'tbl_bookings.phone as phone',
                'tbl_bookings.note as note',
                'tbl_bookings.for as for',
                'tbl_bookings.estimated_time_of_arrival as estimated_time_of_arrival',
                'tbl_bookings.estimated_time_on_site as estimated_time_on_site',
                new Expression('tbl_bookings.numeric_column_headings as numeric_column_headings'),
                'tbl_bookings.text_column_heading as text_column_heading',
                'tbl_bookings.booking_type_id as booking_type_id',
                DBTable::BOOKING_TYPES.'.name as booking_type_name',
                DBTable::JOBS.'.id as related_job_id',
                DBTable::QUOTES.'.id as related_quote_id',
                'tbl_bookings.site_id as site_id',
                'tbl_bookings.created_at as created_at'
            );
            
            if ($bookingTypeId) {
                $bookings = $bookings->where('tbl_bookings.booking_type_id', '=', $bookingTypeId);
            }
        
            if ($siteId) {
                if ($siteId == 3) {
                    $bookings = $bookings->where('tbl_bookings.site_id', '<>', 4);
                }
                
                if ($siteId == 4) {
                    $bookings = $bookings->where('tbl_bookings.site_id', '<>', 3);
                }

                if ($siteId == 3 || $siteId == 4) {
                    $bookings = $bookings->whereIn('tbl_bookings.site_id', [3,4]);
                } else {
                    $bookings = $bookings->where('tbl_bookings.site_id', $siteId);
                }                
            } else {
                $sites = $user->getSharedSiteIds();
                $bookings = $bookings->whereIn('tbl_bookings.site_id', $sites->toArray());   
            }

            // dd($bookings->toSql()); 
            // dd($bookings->get()->unique()->toArray());

            $bookings = $bookings
            ->latest()
            ->get()->unique();
            
        return $this->sendSuccessResponse($bookings->toArray());
    }
}
