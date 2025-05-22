<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class TasksExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Task::select('name', 'description','started_at','ended_at','user_id','progress','priority')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Started At',
            'Ended At',
            'User ID',
            'Progress',
            'Priority',
        ];
    }

    public function styles(Worksheet  $sheet)
    {
        return [
            1=>['font'=>['bold'=>true]],
        ];

    }
}
