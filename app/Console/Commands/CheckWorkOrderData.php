<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WorkOrder;

class CheckWorkOrderData extends Command
{
    protected $signature = 'workorder:check';
    protected $description = 'Check and fix Work Order data issues';

    public function handle()
    {
        $this->info('Checking Work Order data...');

        // Check for Work Orders without wo_number
        $workOrdersWithoutNumber = WorkOrder::whereNull('wo_number')
            ->orWhere('wo_number', '')
            ->get();

        if ($workOrdersWithoutNumber->count() > 0) {
            $this->warn("Found {$workOrdersWithoutNumber->count()} Work Orders without wo_number:");

            foreach ($workOrdersWithoutNumber as $wo) {
                $this->line("ID: {$wo->id}, Output: {$wo->output}, wo_number: '{$wo->wo_number}'");
            }
        } else {
            $this->info('All Work Orders have wo_number');
        }

        // Check for Work Orders with null output
        $workOrdersWithoutOutput = WorkOrder::whereNull('output')
            ->orWhere('output', '')
            ->get();

        if ($workOrdersWithoutOutput->count() > 0) {
            $this->warn("Found {$workOrdersWithoutOutput->count()} Work Orders without output:");

            foreach ($workOrdersWithoutOutput as $wo) {
                $this->line("ID: {$wo->id}, wo_number: {$wo->wo_number}, output: '{$wo->output}'");
            }
        } else {
            $this->info('All Work Orders have output');
        }

        // Show sample data
        $this->info('Sample Work Order data:');
        $sample = WorkOrder::take(5)->get(['id', 'wo_number', 'output', 'due_date']);

        foreach ($sample as $wo) {
            $this->line("ID: {$wo->id}, WO: {$wo->wo_number}, Output: {$wo->output}, Due: {$wo->due_date}");
        }

        return 0;
    }
}


