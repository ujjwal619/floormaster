<?php

namespace App\Imports;

use App\Data\Entities\Models\Supplier\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class StockImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);
//         return new Supplier([
//             'id' => $row[0],
//             'site_id' => 1,
//             'trading_name' => $row[1],
//             'street' => $row[2],
//             'phone' => $row[6],
//             'fax' => $row[7],
//             'abn' => "",
//             'code' => $row[5],
//             'contact' => $row[8],
//             'suburb' => $row[3],
//             'email' => $row[13],
//             'state' => $row[1],
//             'sales_detail' => [
//                 'phone' => $row[9],
//                 'fax' => $row[10],
//                 'quick_dial' => $row[11],
//                 'contact' => $row[12],
//             ],
//             'key_no' => "",
//             'early_discount' => [
//                 'discount' => $row[17]
//             ],
//             'products' => [
//                 'notes' => $row[19]
//             ],
// //            'normal_discount' => $row[1],
// //            'bank' => $row[1],
// //            'default_cost_account' => $row[1],
// //            'levy_account' => $row[1],
//             'delivery' => $row[16],
// //            'central_billing' => $row[1],
// //            'levy_percent' => $row[1],
//         ]);
    }
}
