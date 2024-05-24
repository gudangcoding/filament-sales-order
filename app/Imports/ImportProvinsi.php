<?php

namespace App\Imports;

use App\Models\Provinsi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportProvinsi implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
    }

    public function model(array $row)
    {
        return new Provinsi([
            'id' => $row['id'],
            'name' => $row['name'],
        ]);
    }
}
