<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\WONumberService;
use Illuminate\Console\Command;

class GenerateWONumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wo:generate-number {--prefix= : Custom prefix for WO number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Work Order number with current or custom prefix';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customPrefix = $this->option('prefix');

        if ($customPrefix) {
            // Set custom prefix temporarily
            Setting::setValue('wo_prefix', $customPrefix, 'string', 'wo', 'Custom prefix for testing');
            $this->info("Prefix temporarily set to: {$customPrefix}");
        }

        $currentPrefix = Setting::getValue('wo_prefix', '86');

        // Generate numbers using different formats
        $nextNumberNew = WONumberService::generateNextNumberWithFormat('T');
        $nextNumberLegacy = WONumberService::generateLegacyFormat();

        $this->info("Current WO Prefix: {$currentPrefix}");
        $this->info("Next WO Number (New Format): {$nextNumberNew}");
        $this->info("Next WO Number (Legacy Format): {$nextNumberLegacy}");

        $this->info("");

        // Parse the legacy number to show components
        $this->info("Legacy Format Components:");
        $components = WONumberService::parseWONumber($nextNumberLegacy);
        $this->info("  - Prefix: {$components['prefix']}");
        $this->info("  - Year: {$components['year']}");
        $this->info("  - Month: {$components['month']}");
        $this->info("  - Sequence: {$components['sequence']}");
        $this->info("  - Has T suffix: " . ($components['has_tsuffix'] ? 'Yes' : 'No'));

        if ($customPrefix) {
            // Reset to original prefix
            Setting::setValue('wo_prefix', '86', 'string', 'wo', 'Prefix nomor awal untuk Work Order');
            $this->info("Prefix reset to: 86");
        }

        return Command::SUCCESS;
    }
}
