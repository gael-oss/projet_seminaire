namespace App\Exports;

use App\Models\Seminaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SeminairesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Seminaire::all(['theme', 'date_presentation', 'statut']);
    }

    public function headings(): array
    {
        return ['Thème', 'Date de présentation', 'Statut'];
    }
}
