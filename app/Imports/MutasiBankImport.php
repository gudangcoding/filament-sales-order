<?php

namespace App\Imports;


use App\Models\Customer;
use App\Models\MutasiBank;
use App\Models\MutasiUnmatched;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Import WithHeadingRow if you use headings

class MutasiBankImport implements ToModel, WithHeadingRow
{


    protected $customers;
    protected $saldo;

    public function __construct()
    {
        $this->customers = Customer::pluck('nama')->toArray();
        $this->saldo = 0;
        Log::info('ImportMutasi initialized.');
    }

    public function getColumns(): array
    {
        return [
            'tanggal',
            'keterangan',
            'nama',
            'cabang',
            'jumlah',
            'type',
            'saldo',
        ];
    }

    public function model(array $row)
    {

        $tanggal = $row[0] ?? null;
        $keterangan = $row[1] ?? null;
        $cabang = $row[2] ?? null;
        $type = $row[3] ?? null;


        // Check if 'keterangan' contains a customer name
        $foundCustomer = null;
        foreach ($this->customers as $customer) {
            if (stripos($keterangan, $customer) !== false) {
                $foundCustomer = $customer;
                break;
            }
        }


        // $string = "TRSF E-BANKING CR 2103/FTSCY/WS95031    4147000.00Helmi Sby     HELMI USMAN";
        $string = $keterangan;
        $regex = '/(\d+\.\d{2})$/';
        $matches = array();
        $jumlah = 0;
        preg_match($regex, $string, $matches);

        if (count($matches) > 0) {
            $amount = $matches[1];
            $jumlah = (int)str_replace(['.', ','], '', $amount);
            // echo "Extracted amount: $amount";
            // $jumlah = (int) $jumlah;
        } else {
            $jumlah = 0;
        }



        // // Accumulate saldo based on type
        if ($type === 'CR') {
            $this->saldo += $jumlah;
        } elseif ($type === 'DR') {
            $this->saldo -= $jumlah;
        } else {
            Log::warning('Invalid transaction type.', ['type' => $type]);
            return null;
        }

        $data = [
            'team_id' => 1,
            'user_id' => 1,
            'tanggal' => $tanggal,
            'keterangan' => $keterangan,
            'nama' => $foundCustomer,
            'cabang' => $cabang,
            'jumlah' => $jumlah,
            'type' => $type,
            'saldo' => $this->saldo,
        ];
        dd($data);
        // return new MutasiBank($data);
    }

    private function saveUnmatchedRow(array $row)
    {
        // Handle unmatched rows
        $data = [
            'tanggal' => $row['tanggal'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
            'cabang' => $row['cabang'] ?? null,
            'type' => $row['type'] ?? null,
        ];
        MutasiUnmatched::create($data);
    }
}
