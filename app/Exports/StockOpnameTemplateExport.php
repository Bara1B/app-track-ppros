<?php

namespace App\Exports;

/**
 * Stock Opname Template Export
 * 
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedNamespaceInspection
 * @noinspection PhpUndefinedMethodInspection
 */

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * @mixin FromArray
 * @mixin WithHeadings
 * @mixin WithStyles
 * @mixin WithColumnWidths
 */

class StockOpnameTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        // Sample data sesuai dengan screenshot
        return [
            [
                '1',
                'BBE0121',
                '✓',
                '14303146',
                'CITRUS BIOFLAV',
                'Kg',
                '24/01/0177',
                '25',
                '2.1111',
                '15/03/26',
                '', // Stock Fisik - akan diisi user
                '-2.1111', // Selisih (Quantity - Stock Fisik)
                '', // Overmate - akan diisi sistem
                'YA', // Masuk - akan diisi sistem
                '', // Keterangan
            ],
            [
                '2',
                'BBE0121',
                '✓',
                '14303146',
                'CITRUS BIOFLAV',
                'Kg',
                '24/02/0347',
                '25',
                '14.2191',
                '04/04/26',
                '', // Stock Fisik - akan diisi user
                '-14.2191', // Selisih
                '', // Overmate
                'YA', // Masuk
                '', // Keterangan
            ],
            [
                '3',
                'BBE0122',
                '✓',
                '14319150',
                'SODIUM ACETAT',
                'Kg',
                '23/01/0902U1',
                '24',
                '18.3158',
                '27/03/26',
                '', // Stock Fisik - akan diisi user
                '-18.3158', // Selisih
                '', // Overmate
                '', // Masuk
                '', // Keterangan
            ],
            [
                '4',
                'BBE0122',
                '✓',
                '14303101',
                'COCOA POWDER',
                'Kg',
                '24/01/0092',
                '25',
                '78.2645',
                '09/12/25',
                '', // Stock Fisik - akan diisi user
                '-78.2645', // Selisih
                '', // Overmate
                '', // Masuk
                '', // Keterangan
            ],
            [
                '5',
                'BBE0122',
                '✓',
                '14309104',
                'ISOSORBIDE 5-M',
                'Kg',
                '21/01/0898U2',
                '5',
                '0.642',
                '22/01/26',
                '', // Stock Fisik - akan diisi user
                '-0.642', // Selisih
                '', // Overmate
                'YA', // Masuk
                '', // Keterangan
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Location System',
            'Location Actual',
            'Item Number',
            'Description',
            'UM',
            'Lot/Serial',
            'Reference',
            'Quantity On Hand',
            'Expire Date',
            'Stock Fisik', // Kolom untuk input user
            'Selisih', // Quantity - Stock Fisik
            'Overmate', // Akan diisi sistem
            'Masuk', // Akan diisi sistem
            'Keterangan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 15,  // Location System
            'C' => 15,  // Location Actual
            'D' => 12,  // Item Number
            'E' => 25,  // Description
            'F' => 8,   // UM
            'G' => 15,  // Lot/Serial
            'H' => 12,  // Reference
            'I' => 15,  // Quantity On Hand
            'J' => 12,  // Expire Date
            'K' => 12,  // Stock Fisik
            'L' => 12,  // Selisih
            'M' => 12,  // Overmate
            'N' => 10,  // Masuk
            'O' => 20,  // Keterangan
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Data rows
            'A2:O100' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Center ticks in Location Actual column
            'C:C' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Stock Fisik column highlight (input user)
            'K:K' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFF2CC']
                ],
            ],
            // Selisih column highlight (calculated)
            'L:L' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E8F4FD']
                ],
            ],
            // Overmate column highlight (system)
            'M:M' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FCE4D6']
                ],
            ],
            // Masuk column highlight (system)
            'N:N' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E1D5E7']
                ],
            ],
        ];
    }
}
