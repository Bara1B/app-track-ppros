<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $item_number
 * @property string $kode
 * @property string $description
 * @property string $uom
 * @property string $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereItemNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterProduct whereUpdatedAt($value)
 */
	class MasterProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $item_number
 * @property string|null $nama_bahan
 * @property string|null $manufactur
 * @property string $overmate_qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereItemNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereManufactur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereNamaBahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereOvermateQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Overmate whereUpdatedAt($value)
 */
	class Overmate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $item_number
 * @property string $nama_bahan
 * @property string $manufacturer
 * @property string $lot_serial
 * @property string $overmate
 * @property string $uom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereItemNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereLotSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereNamaBahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereOvermate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OvermateMaster whereUpdatedAt($value)
 */
	class OvermateMaster extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $work_order_id
 * @property string $item_number
 * @property string $description
 * @property string $qty_required
 * @property string $uom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereItemNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQtyRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWorkOrderId($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property string $group
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $file_id
 * @property string $location_system
 * @property string|null $location_actual
 * @property string|null $location_actual_notes
 * @property string $item_number
 * @property string $description
 * @property string $manufacturer
 * @property string $lot_serial
 * @property string $reference
 * @property string $quantity_on_hand
 * @property string|null $stok_fisik
 * @property string|null $masuk_kategori
 * @property string|null $keterangan
 * @property string|null $stok_fisik_history
 * @property string $unit_of_measure
 * @property \Illuminate\Support\Carbon $expired_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\StockOpnameFile|null $file
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereItemNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereLocationActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereLocationActualNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereLocationSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereLotSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereMasukKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereQuantityOnHand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereStokFisik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereStokFisikHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereUnitOfMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereUpdatedAt($value)
 */
	class StockOpname extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property string $original_name
 * @property string $file_path
 * @property int $file_size
 * @property int|null $uploaded_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $imported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockOpname> $stockOpnames
 * @property-read int|null $stock_opnames_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereImportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameFile whereUploadedBy($value)
 */
	class StockOpnameFile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $wo_number
 * @property string|null $output
 * @property string $due_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderTracking> $tracking
 * @property-read int|null $tracking_count
 * @method static \Database\Factories\WorkOrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereWoNumber($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $completed_on
 * @property-read \App\Models\MasterProduct|null $masterProduct
 * @property-read \App\Models\WorkOrderTracking|null $woDiterimaTracking
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCompletedOn($value)
 */
	class WorkOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $work_order_id
 * @property string $status_name
 * @property string|null $completed_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereWorkOrderId($value)
 * @mixin \Eloquent
 */
	class WorkOrderTracking extends \Eloquent {}
}

