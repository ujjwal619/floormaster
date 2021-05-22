<?php

namespace App\Imports;

use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Supplier\Manager;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuppliersImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
        
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $glCode = $row['glcode'];
        $siteId = config('fms.import.default_site');
        $supplierManager = app(Manager::class);
        $supplier = $supplierManager->findWhere([
            'trading_name' => $row['supplier'], 
            'site_id' => $siteId
        ]);
        if(!$supplier) {
            $supplierData = [
                // 'id' => $row[0],
                'site_id' => $siteId,
                'trading_name' => $row['supplier'],
                'street' => $row['street'],
                'phone' => $row['acphone'],
                'fax' => $row['acfax'],
                'abn' => "",
                'code' => $row['postcode'],
                'contact' => $row['accontact'],
                'suburb' => $row['suburb'],
                'email' => $row['email'],
                'state' => $row['state'],
                'sales_detail' => [
                    'phone' => $row['salesphone'],
                    'fax' => $row['salesfax'],
                    'quick_dial' => $row['quickdial'],
                    'contact' => $row['contact'],
                ],
                'key_no' => "",
                'early_discount' => [
                    'discount' => $row['earlydisc']
                ],
                'products' => [
                    'notes' => $row['notes']
                ],
                'delivery' => $row['baling'],
    //            'normal_discount' => $row[1],
    //            'bank' => $row[1],
    //            'default_cost_account' => $row[1],
    //            'levy_account' => $row[1],
    //            'central_billing' => $row[1],
    //            'levy_percent' => $row[1],
            ];
            return new Supplier($supplierData);
        }
    }
}
