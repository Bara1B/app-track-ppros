# Class Diagram - Laravel Work Order Management System

```mermaid
classDiagram
    %% Core Models
    class User {
        +int id
        +string name
        +string email
        +string role
        +string password
        +datetime email_verified_at
        +datetime created_at
        +datetime updated_at
        +string remember_token
    }

    class WorkOrder {
        +int id
        +string wo_number
        +string output
        +date due_date
        +string status
        +datetime completed_on
        +datetime created_at
        +datetime updated_at
        +products() HasMany
        +tracking() HasMany
        +woDiterimaTracking() HasOne
        +masterProduct() HasOne
    }

    class Product {
        +int id
        +int work_order_id
        +string item_number
        +string description
        +string qty_required
        +string uom
        +datetime created_at
        +datetime updated_at
        +workOrder() BelongsTo
    }

    class WorkOrderTracking {
        +int id
        +int work_order_id
        +string status_name
        +datetime completed_at
        +string notes
        +datetime created_at
        +datetime updated_at
        +workOrder() BelongsTo
    }

    class MasterProduct {
        +int id
        +string description
        +datetime created_at
        +datetime updated_at
    }

    class StockOpname {
        +int id
        +int file_id
        +string location_system
        +string item_number
        +string description
        +string manufacturer
        +string lot_serial
        +string reference
        +string quantity_on_hand
        +string stok_fisik
        +string unit_of_measure
        +date expired_date
        +datetime created_at
        +datetime updated_at
        +file() BelongsTo
    }

    class StockOpnameFile {
        +int id
        +string filename
        +string original_name
        +string file_path
        +int file_size
        +int uploaded_by
        +string status
        +datetime imported_at
        +datetime created_at
        +datetime updated_at
        +stockOpnames() HasMany
        +user() BelongsTo
    }

    class Overmate {
        +int id
        +string item_number
        +string nama_bahan
        +string manufactur
        +string overmate_qty
        +datetime created_at
        +datetime updated_at
        +getRouteKeyName() string
    }

    class OvermateMaster {
        +int id
        +string item_number
        +string nama_bahan
        +string manufacturer
        +string lot_serial
        +string overmate
        +string uom
        +datetime created_at
        +datetime updated_at
    }

    class Setting {
        +int id
        +string key
        +string value
        +string type
        +string group
        +string description
        +datetime created_at
        +datetime updated_at
        +getValue(key, default) static
        +setValue(key, value, type, group, description) static
        +getByGroup(group) static
        +getWOPrefix() static
        +setWOPrefix(prefix) static
    }

    %% Services
    class WONumberService {
        +generateNextNumber() static string
        +generateNextNumberWithFormat(format) static string
        +generateLegacyFormat() static string
        +validateFormat(woNumber) static bool
        +parseWONumber(woNumber) static array
    }

    %% Helpers
    class NotificationHelper {
        +success(message) static
        +error(message) static
        +warning(message) static
        +info(message) static
        +operation(success, successMessage, errorMessage) static
        +created(itemName) static
        +updated(itemName) static
        +deleted(itemName) static
        +verified(itemName) static
        +imported(itemName) static
        +exported(itemName) static
    }

    %% Laravel Base Classes
    class Model {
        <<abstract>>
    }

    class Authenticatable {
        <<abstract>>
    }

    %% Relationships
    User ||--o{ StockOpnameFile : "uploaded_by"
    User --|> Authenticatable : extends

    WorkOrder ||--o{ Product : "has many"
    WorkOrder ||--o{ WorkOrderTracking : "has many"
    WorkOrder ||--o| MasterProduct : "has one (by description)"

    Product }o--|| WorkOrder : "belongs to"

    WorkOrderTracking }o--|| WorkOrder : "belongs to"

    StockOpnameFile ||--o{ StockOpname : "has many"
    StockOpname }o--|| StockOpnameFile : "belongs to"

    StockOpnameFile }o--|| User : "belongs to"

    %% Service Dependencies
    WONumberService ..> Setting : uses
    WONumberService ..> WorkOrder : uses

    %% Model Inheritance
    User --|> Model : extends
    WorkOrder --|> Model : extends
    Product --|> Model : extends
    WorkOrderTracking --|> Model : extends
    MasterProduct --|> Model : extends
    StockOpname --|> Model : extends
    StockOpnameFile --|> Model : extends
    Overmate --|> Model : extends
    OvermateMaster --|> Model : extends
    Setting --|> Model : extends
```

## Penjelasan Class Diagram

### Model Utama:

1. **User** - Model untuk pengguna sistem dengan autentikasi Laravel
2. **WorkOrder** - Model utama untuk Work Order dengan relasi ke Product dan Tracking
3. **Product** - Model untuk item-item dalam Work Order
4. **WorkOrderTracking** - Model untuk tracking status Work Order
5. **MasterProduct** - Model master data produk
6. **StockOpname** - Model untuk data stock opname
7. **StockOpnameFile** - Model untuk file upload stock opname
8. **Overmate** - Model untuk data overmate
9. **OvermateMaster** - Model master data overmate
10. **Setting** - Model untuk konfigurasi sistem

### Service dan Helper:

1. **WONumberService** - Service untuk generate nomor Work Order
2. **NotificationHelper** - Helper untuk notifikasi sistem

### Relasi Utama:

- **WorkOrder** memiliki banyak **Product** dan **WorkOrderTracking**
- **Product** dan **WorkOrderTracking** belongs to **WorkOrder**
- **StockOpnameFile** memiliki banyak **StockOpname**
- **StockOpnameFile** belongs to **User** (uploaded_by)
- **WONumberService** menggunakan **Setting** dan **WorkOrder**

Semua model extends dari Laravel **Model** class, dan **User** extends dari **Authenticatable** untuk fitur autentikasi.