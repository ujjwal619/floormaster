<?php

namespace App\Imports;

use App\Data\Entities\Models\Product\Product;
use App\FMS\Product\Manager as ProductManager;
use App\FMS\ProductCategory\Manager as ProductCategoryManager;
use App\FMS\Supplier\Manager as SupplierManager; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
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
        try {
            $categoryManager = app(ProductCategoryManager::class);
            $supplierManager = app(SupplierManager::class);
            $productmanager = app(ProductManager::class);
            $siteId = config('fms.import.default_site');
            if ($row['cat']) {
                $category = $categoryManager->findWhere(['title' => $row['cat'], 'site_id' => $siteId]);
                throw_if(!$category, new \Exception('Category not found.'));

                $supplier = $supplierManager->findWhere(['trading_name' => $row['supplier'], 'site_id' => $siteId]);
                throw_if(!$supplier, new \Exception('Supplier not found.'));

                $product = $productmanager->findWhere(['name' => $row['range'], 'site_id' => $siteId]);
                if (!$product) {
                    $productData = [
                        'supplier_id' => $supplier->id,
                        'site_id' => $siteId,
                        'name' => $row['range'],
                        'alias' => $row['alias'],
                        'price_base' => $row['pricebase'],
                        'category_id' => $category->id,
                        'list_cost'  => $row['listcost'],
                        'upc' => $row['upc'],
                        'discount' => $row['disc'],
                        'gst' => $row['tax'], 
                        'width' => $row['tax'],
                        'unit',
                        'trade_sell' => [
                            'gp' => $row['trademarkup'],
                            'margin' => $row['trademargin'],
                            'net_sell' => $row['tradesell'],
                            'with_gst' => $row['gsttradesell'],
                        ],
                        'retail_sell' => [
                            'gp' => $row['rrpmarkup'],
                            'margin' => $row['rrpmargin'],
                            'net_sell' => $row['rrpsell'],
                            'with_gst' => $row['gstrrpsell'],
                        ],
                        'installed' => [
                            'gp' => $row['servicedmarkup'],
                            'other' => $row['other'],
                            'extra_materials' => $row['materials'],
                            'labours' => $row['labours'],
                            'margin' => $row['servicedmargin'],
                            'net_sell' => $row['servicedsell'],
                            'with_gst' => $row['gstserviced'],
                        ],
                        'act_on_me' => true,
                        'exclude_from_report' => false,
                    ];

                    return new Product($productData);
                }

            }            
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
        
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
