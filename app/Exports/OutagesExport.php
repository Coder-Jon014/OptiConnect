<?php

namespace App\Exports;

use App\Models\OutageHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OutagesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return OutageHistory::with('olt', 'team', 'sla')->get()->map(function($outage) {
            return [
                'OLT Name' => $outage->olt->olt_name,
                'Team Name' => $outage->team->team_name,
                'Team Type' => $outage->team->team_type,
                'Start Time' => $outage->start_time,
                'End Time' => $outage->end_time,
                'Duration' => $outage->duration,
                'Refund Amount' => $outage->sla ? $outage->sla->refund_amount : '0.00',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'OLT Name',
            'Team Name',
            'Team Type',
            'Start Time',
            'End Time',
            'Duration',
            'Refund Amount',
        ];
    }
}
