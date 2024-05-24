<?php

namespace App\Imports;

use App\Models\Provinsi;
use Filament\Facades\Filament;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvinsiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // return new Provinsi([
        //     'id' => $row[0],
        //     'name' => $row[1],
        //     'team_id' => Filament::getTenant()->id,
        //     'user_id' => auth()->id(),
        // ]);

        return new Provinsi([
            // 'id' => $row[0],
            // 'name' => $row[1],
            'id' => $row['id'],
            'name' => $row['nm'],
            'team_id' => Filament::getTenant()->id,
            'user_id' => auth()->id(),
        ]);
    }
}
