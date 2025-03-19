<?php
namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Absensi::query();

        if (!empty($this->filter['kelas_id'])) {
            $query->where('kelas_id', $this->filter['kelas_id']);
        }

        if (!empty($this->filter['start_date'])) {
            $query->where('created_at', '>=', $this->filter['start_date']);
        }

        if (!empty($this->filter['end_date'])) {
            $query->where('created_at', '<=', $this->filter['end_date']);
        }

        return $query->with(['kelas', 'pertemuan', 'user'])->orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Pertemuan Ke',
            'Status',
            'Tanggal Absensi',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user->nama_lengkap ?? '-',
            $row->kelas->nama_kelas ?? '-',
            $row->pertemuan->pertemuan_ke ?? '-',
            $row->status,
            $row->created_at->format('d-m-Y'),
        ];
    }
}
