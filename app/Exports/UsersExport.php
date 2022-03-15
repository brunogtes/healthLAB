<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserCustomModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["Name", "Email"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UserCustomModel::select('nome','email')->get();
    }
} 