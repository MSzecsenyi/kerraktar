<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ItemImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // error_log($row[0]);
        return new Item([
            'store_id' => 1,
            'item_name' => $row['nev'],
            'amount' => $row['mennyiseg'],
            'in_store_amount' => $row['mennyiseg'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nev' => 'required|string|min:2|max:50',
            'mennyiseg' => 'required|integer|min:1|max:999'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nev.required' => 'Név megadása kötelező',
            'nev.min' => 'Név hossza minimum :min karakter',
            'nev.max' => 'Név hossza maximum :max karakter',

            'mennyiseg.required' => 'Mennyiség megadása kötelező',
            'mennyiseg.min' => 'Mennyiség minimum :min karakter',
            'mennyiseg.max' => 'Mennyiség maximum :max karakter',
        ];
    }
}
