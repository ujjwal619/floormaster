<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\CommissionsExport;
use App\FMS\Reports\Job\Queries\CommissionQuery;
use App\FMS\Reports\ReportType;
use App\FMS\SalesStaff\Manager as SalesStaffManager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportCommission extends AdminController
{
    private $salesStaffManager;

    public function __construct(SalesStaffManager $salesStaffManager)
    {
        $this->salesStaffManager = $salesStaffManager;
    }
    public function __invoke(
        Request $request,
        CommissionQuery $commissionQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new CommissionsExport($request, $commissionQuery, $this->salesStaffManager), 'commission_report.pdf', ExcelExcel::MPDF);
            }
            
            return Excel::download(new CommissionsExport($request, $commissionQuery, $this->salesStaffManager), 'commission_report.xls');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
