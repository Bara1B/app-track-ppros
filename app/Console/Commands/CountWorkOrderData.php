<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterProduct;
use Illuminate\Support\Facades\DB;

class CountWorkOrderData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wo:count-data {--group= : Filter by specific group} {--uom= : Filter by specific UOM} {--search= : Search in item_number, kode, or description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count Work Order Data Master (MasterProduct) records with detailed breakdowns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $group = $this->option('group');
        $uom = $this->option('uom');
        $search = $this->option('search');

        $this->info('🏭 Work Order Data Master Count');
        $this->info('==============================');

        if ($group || $uom || $search) {
            $this->countFilteredData($group, $uom, $search);
        } else {
            $this->countAllData();
        }
    }

    private function countAllData()
    {
        // Basic counts
        $total = MasterProduct::count();
        $uniqueGroups = MasterProduct::distinct()->count('group');
        $uniqueUOMs = MasterProduct::distinct()->count('uom');
        $uniqueItemNumbers = MasterProduct::distinct()->count('item_number');
        $uniqueKodes = MasterProduct::distinct()->count('kode');

        $this->info("\n📊 Basic Counts:");
        $this->line("   Total Records: {$total}");
        $this->line("   Unique Item Numbers: {$uniqueItemNumbers}");
        $this->line("   Unique Kodes: {$uniqueKodes}");
        $this->line("   Unique Groups: {$uniqueGroups}");
        $this->line("   Unique UOMs: {$uniqueUOMs}");

        // Count by group
        $this->info("\n🏷️  Count by Group:");
        $groupCounts = MasterProduct::select('group', DB::raw('count(*) as total'))
            ->groupBy('group')
            ->orderBy('total', 'desc')
            ->get();

        foreach ($groupCounts as $group) {
            $percentage = round(($group->total / $total) * 100, 1);
            $this->line("   {$group->group}: {$group->total} ({$percentage}%)");
        }

        // Count by UOM
        $this->info("\n📏 Count by Unit of Measure:");
        $uomCounts = MasterProduct::select('uom', DB::raw('count(*) as total'))
            ->groupBy('uom')
            ->orderBy('total', 'desc')
            ->get();

        foreach ($uomCounts as $uom) {
            $percentage = round(($uom->total / $total) * 100, 1);
            $this->line("   {$uom->uom}: {$uom->total} ({$percentage}%)");
        }

        // Recent additions
        $this->info("\n🕒 Recent Activity:");
        $recentCount = MasterProduct::where('created_at', '>=', now()->subDays(7))->count();
        $this->line("   Added in last 7 days: {$recentCount}");

        $monthlyCount = MasterProduct::where('created_at', '>=', now()->startOfMonth())->count();
        $this->line("   Added this month: {$monthlyCount}");

        // Data quality check
        $this->info("\n✅ Data Quality Check:");
        $withDescription = MasterProduct::whereNotNull('description')->where('description', '!=', '')->count();
        $withoutDescription = $total - $withDescription;
        $this->line("   With Description: {$withDescription}");
        $this->line("   Without Description: {$withoutDescription}");

        $withGroup = MasterProduct::whereNotNull('group')->where('group', '!=', '')->count();
        $withoutGroup = $total - $withGroup;
        $this->line("   With Group: {$withGroup}");
        $this->line("   Without Group: {$withoutGroup}");
    }

    private function countFilteredData($group = null, $uom = null, $search = null)
    {
        $query = MasterProduct::query();

        if ($group) {
            $query->where('group', 'like', "%{$group}%");
            $this->info("🔍 Filtering by Group: {$group}");
        }

        if ($uom) {
            $query->where('uom', 'like', "%{$uom}%");
            $this->info("🔍 Filtering by UOM: {$uom}");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('item_number', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
            $this->info("🔍 Searching for: {$search}");
        }

        $total = $query->count();

        if ($total === 0) {
            $this->warn("❌ No records found with the specified filters.");
            return;
        }

        $this->info("\n📊 Filtered Results:");
        $this->line("   Total Records: {$total}");

        // Show sample records
        $sampleRecords = $query->limit(5)->get(['item_number', 'kode', 'description', 'group', 'uom']);

        $this->info("\n📋 Sample Records:");
        foreach ($sampleRecords as $record) {
            $this->line("   {$record->item_number} | {$record->kode} | {$record->group} | {$record->uom}");
            $this->line("     Description: {$record->description}");
        }

        if ($total > 5) {
            $this->line("   ... and " . ($total - 5) . " more records");
        }
    }
}
