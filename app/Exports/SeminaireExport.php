<?php

namespace App\Exports;

use App\Models\Seminaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SeminaireExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Seminaire::select('theme', 'resume', 'date_presentation', 'statut')->get();
    }

    public function headings(): array
    {
        return ['Thème', 'Résumé', 'Date de présentation', 'Statut'];
    }
}
