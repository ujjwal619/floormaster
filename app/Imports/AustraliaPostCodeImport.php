<?php

namespace App\Imports;

use App\FMS\PostCode\Manager;
use App\FMS\PostCode\Models\AustraliaPostCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AustraliaPostCodeImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $postCodeManager = app(Manager::class);
        $postCode = $postCodeManager->findWhere([
            'postcode' => $row['postcode'], 
            'suburb' => $row['suburb'],
            'state' => $row['state']
        ]);

        if (!$postCode) {
            return new AustraliaPostCode([
                'postcode' => $row['postcode'],
                'suburb' => $row['suburb'],
                'state' => $row['state'],
                'dc' => $row['dc'],
                'type' => $row['type'],
            ]);
        }
    }
}
