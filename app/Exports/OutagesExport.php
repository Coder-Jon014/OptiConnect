<?php

namespace App\Exports;

use App\Models\OutageHistory;
use App\Models\OutageTypes;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;

class OutagesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        return OutageHistory::with('olt', 'team', 'sla', 'outageType')
            ->where('status', false)
            ->get()
            ->map(function($outage) {
                $outageType = $outage->outage_type_id;
                $outageType = OutageTypes::find($outageType)->outage_type_name;
                $deploymentCost = $outage->team_id;
                $deploymentCost = Team::find($deploymentCost)->deployment_cost;
                $refundAmount = $outage->sla ? number_format($outage->sla->refund_amount, 2) : '0.00';
                return [
                    'OLT Name' => $outage->olt->olt_name,
                    'Team Name' => $outage->team->team_name,
                    'Team Type' => $outage->team->team_type,
                    'Outage Type' => $outageType,
                    'Start Time' => Date::dateTimeToExcel($outage->start_time) ?? null,
                    'End Time' => Date::dateTimeToExcel($outage->end_time) ?? null,
                    'Duration' => $outage->duration,
                    'Refund Amount' => $refundAmount,
                    'Deployment Cost' => $deploymentCost,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'OLT Name',
            'Team Name',
            'Team Type',
            'Outage Type',
            'Start Time',
            'End Time',
            'Duration',
            'Refund Amount',
            'Deployment Cost',
        ];
    }

    public function columnFormats(): array
    {
        return [

            'E' => NumberFormat::FORMAT_DATE_DATETIME,
            'F' => NumberFormat::FORMAT_DATE_DATETIME,
            'H' => NumberFormat::FORMAT_CURRENCY_USD,
            'I' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }


}