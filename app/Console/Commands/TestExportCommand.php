<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OutagesExport;

class TestExportCommand extends Command
{
    protected $signature = 'test:export';
    protected $description = 'Test Excel Export';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \Log::info('Running Test Export Command...');
        Excel::store(new OutagesExport, 'test_export.xlsx');
        $this->info('Export completed');
    }
}
