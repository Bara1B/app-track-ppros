# Work Order Filters - Public Page

## Overview
The public work order page now includes comprehensive filtering capabilities to help users find specific work orders more easily.

## Available Filters

### 1. Search Filter
- **Field**: Search input
- **Purpose**: Search work orders by WO Number, Output (product name), or ID Number
- **Usage**: Type any part of the work order identifier or product name
- **Example**: Type "8004" to find work orders starting with that number

### 2. Status Filter
- **Field**: Status dropdown
- **Purpose**: Filter by specific tracking status
- **Options**: 
  - Semua Status (All Statuses)
  - WO Diterima
  - Timbang
  - Selesai Timbang
  - Potong Stock
  - Released
  - Kirim BB
  - Kirim CPB/WO
  - Mulai Timbang
- **Behavior**: Auto-submits when changed (except "All Statuses")

### 3. Completion Status Filter
- **Field**: Completion status dropdown
- **Purpose**: Filter by overall completion status
- **Options**:
  - Semua (All)
  - Selesai (Completed)
  - Dalam Proses (In Progress)
- **Behavior**: Auto-submits when changed

### 4. Due Date Range Filter
- **Fields**: Due Date From and Due Date To
- **Purpose**: Filter work orders within a specific due date range
- **Format**: Date picker (YYYY-MM-DD)
- **Usage**: Set start and end dates to find work orders due in that period

### 5. Overdue Filter
- **Field**: Checkbox
- **Purpose**: Show only overdue work orders
- **Behavior**: Auto-submits when checked/unchecked
- **Definition**: Work orders with due date in the past that are not yet completed

## User Experience Features

### Auto-Submit
- Status and completion status changes automatically apply filters
- Overdue checkbox automatically applies when toggled
- Reduces need to click "Apply Filters" button

### Loading States
- Submit button shows loading spinner during filter application
- Button text changes to "Memproses..." (Processing...)

### Filter Persistence
- All filter values are preserved during pagination
- URL contains all active filter parameters
- Easy to share filtered results via URL

### Reset Functionality
- Reset button clears all filters and returns to default view
- JavaScript automatically clears form fields before reset

### No Results Handling
- Shows helpful message when filters return no results
- Provides quick reset option
- Explains why no results were found

## Technical Implementation

### Controller Changes
- `PublicHomeController::workOrders()` method now accepts `Request` parameter
- Implements query building with multiple filter conditions
- Returns `statusOptions` and `filters` to view

### View Changes
- Added comprehensive filter form with proper styling
- Responsive grid layout for filter options
- JavaScript enhancements for better UX

### Database Queries
- Uses Laravel's query builder for efficient filtering
- Implements proper relationships with `tracking` table
- Maintains performance with proper indexing

## Usage Examples

### Find Overdue Work Orders
1. Check "Hanya yang Overdue" checkbox
2. Results automatically update to show overdue items

### Search for Specific Product
1. Type product name in search field
2. Click "Terapkan Filter" or press Enter
3. View matching work orders

### Filter by Date Range
1. Set "Due Date Dari" to start date
2. Set "Due Date Sampai" to end date
3. Click "Terapkan Filter"
4. View work orders due in that period

### Combine Multiple Filters
1. Select specific status (e.g., "WO Diterima")
2. Set completion status to "Dalam Proses"
3. Set date range
4. Apply filters to see highly specific results

## Browser Compatibility
- Modern browsers with ES6+ support
- Responsive design for mobile and desktop
- Graceful degradation for older browsers

## Performance Considerations
- Filters are applied at database level for efficiency
- Pagination maintains performance with large datasets
- Query optimization through proper indexing
- Minimal JavaScript for fast page loads

