<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\Overmate;
use App\Models\StockOpnameFile;
use App\Models\Product;
use App\Models\MasterProduct;
use Illuminate\Support\Facades\DB;

class CountData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:count {--table= : Specific table to count} {--status= : Filter by status} {--role= : Filter by user role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count data in various tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->option('table');
        $status = $this->option('status');
        $role = $this->option('role');

        if ($table) {
            $this->countSpecificTable($table, $status, $role);
        } else {
            $this->countAllTables();
        }
    }

    private function countAllTables()
    {
        $this->info('📊 Data Count Summary');
        $this->info('==================');

        // Users
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'admin')->count();
        $regularUsers = User::where('role', 'user')->count();

        $this->info("👥 Users:");
        $this->line("   Total: {$totalUsers}");
        $this->line("   Admin: {$adminUsers}");
        $this->line("   Regular: {$regularUsers}");

        // Work Orders
        $totalWO = WorkOrder::count();
        $completedWO = WorkOrder::where('status', 'Completed')->count();
        $ongoingWO = WorkOrder::where('status', 'On Progress')->count();
        $pendingWO = WorkOrder::where('status', 'Pending')->count();

        $this->info("\n📋 Work Orders:");
        $this->line("   Total: {$totalWO}");
        $this->line("   Completed: {$completedWO}");
        $this->line("   On Progress: {$ongoingWO}");
        $this->line("   Pending: {$pendingWO}");

        // Overmates
        $totalOvermate = Overmate::count();
        $uniqueItems = Overmate::distinct()->count('item_number');
        $uniqueManufacturers = Overmate::distinct()->count('manufactur');

        $this->info("\n🏭 Overmates:");
        $this->line("   Total Records: {$totalOvermate}");
        $this->line("   Unique Items: {$uniqueItems}");
        $this->line("   Unique Manufacturers: {$uniqueManufacturers}");

        // Stock Opname Files
        $totalFiles = StockOpnameFile::count();
        $activeFiles = StockOpnameFile::where('status', '!=', 'deleted')->count();

        $this->info("\n📁 Stock Opname Files:");
        $this->line("   Total: {$totalFiles}");
        $this->line("   Active: {$activeFiles}");

        // Products
        $totalProducts = Product::count();

        $this->info("\n📦 Products:");
        $this->line("   Total: {$totalProducts}");

        // Master Products (Work Order Data Master)
        $totalMasterProducts = MasterProduct::count();
        $uniqueGroups = MasterProduct::distinct()->count('group');
        $uniqueUOMs = MasterProduct::distinct()->count('uom');

        $this->info("\n🏭 Master Products (Work Order Data):");
        $this->line("   Total: {$totalMasterProducts}");
        $this->line("   Unique Groups: {$uniqueGroups}");
        $this->line("   Unique UOMs: {$uniqueUOMs}");

        $this->info("\n✨ Summary Complete!");
    }

    private function countSpecificTable($table, $status = null, $role = null)
    {
        $this->info("📊 Counting data in table: {$table}");

        switch (strtolower($table)) {
            case 'users':
                $this->countUsers($role);
                break;
            case 'workorders':
            case 'work_orders':
                $this->countWorkOrders($status);
                break;
            case 'overmates':
                $this->countOvermates();
                break;
            case 'stockopname':
            case 'stock_opname':
                $this->countStockOpname();
                break;
            case 'products':
                $this->countProducts();
                break;
            case 'masterproducts':
            case 'master_products':
                $this->countMasterProducts();
                break;
            default:
                $this->error("❌ Unknown table: {$table}");
                $this->info("Available tables: users, workorders, overmates, stockopname, products, masterproducts");
        }
    }

    private function countUsers($role = null)
    {
        if ($role) {
            $count = User::where('role', $role)->count();
            $this->info("👥 Users with role '{$role}': {$count}");
        } else {
            $total = User::count();
            $admin = User::where('role', 'admin')->count();
            $regular = User::where('role', 'user')->count();

            $this->info("👥 Users Summary:");
            $this->line("   Total: {$total}");
            $this->line("   Admin: {$admin}");
            $this->line("   Regular: {$regular}");
        }
    }

    private function countWorkOrders($status = null)
    {
        if ($status) {
            $count = WorkOrder::where('status', $status)->count();
            $this->info("📋 Work Orders with status '{$status}': {$count}");
        } else {
            $total = WorkOrder::count();
            $completed = WorkOrder::where('status', 'Completed')->count();
            $ongoing = WorkOrder::where('status', 'On Progress')->count();
            $pending = WorkOrder::where('status', 'Pending')->count();

            $this->info("📋 Work Orders Summary:");
            $this->line("   Total: {$total}");
            $this->line("   Completed: {$completed}");
            $this->line("   On Progress: {$ongoing}");
            $this->line("   Pending: {$pending}");
        }
    }

    private function countOvermates()
    {
        $total = Overmate::count();
        $uniqueItems = Overmate::distinct()->count('item_number');
        $uniqueManufacturers = Overmate::distinct()->count('manufactur');

        $this->info("🏭 Overmates Summary:");
        $this->line("   Total Records: {$total}");
        $this->line("   Unique Items: {$uniqueItems}");
        $this->line("   Unique Manufacturers: {$uniqueManufacturers}");
    }

    private function countStockOpname()
    {
        $total = StockOpnameFile::count();
        $active = StockOpnameFile::where('status', '!=', 'deleted')->count();
        $deleted = StockOpnameFile::where('status', 'deleted')->count();

        $this->info("📁 Stock Opname Files Summary:");
        $this->line("   Total: {$total}");
        $this->line("   Active: {$active}");
        $this->line("   Deleted: {$deleted}");
    }

    private function countProducts()
    {
        $total = Product::count();
        $this->info("📦 Products Total: {$total}");
    }

    private function countMasterProducts()
    {
        $total = MasterProduct::count();
        $uniqueGroups = MasterProduct::distinct()->count('group');
        $uniqueUOMs = MasterProduct::distinct()->count('uom');
        $uniqueItemNumbers = MasterProduct::distinct()->count('item_number');
        $uniqueKodes = MasterProduct::distinct()->count('kode');

        $this->info("🏭 Master Products (Work Order Data Master) Summary:");
        $this->line("   Total Records: {$total}");
        $this->line("   Unique Item Numbers: {$uniqueItemNumbers}");
        $this->line("   Unique Kodes: {$uniqueKodes}");
        $this->line("   Unique Groups: {$uniqueGroups}");
        $this->line("   Unique UOMs: {$uniqueUOMs}");

        // Count by group
        $groupCounts = MasterProduct::select('group', DB::raw('count(*) as total'))
            ->groupBy('group')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        if ($groupCounts->isNotEmpty()) {
            $this->info("\n   Top 5 Groups:");
            foreach ($groupCounts as $group) {
                $this->line("     {$group->group}: {$group->total}");
            }
        }
    }
}
