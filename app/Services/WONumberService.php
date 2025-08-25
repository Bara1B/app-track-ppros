<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\WorkOrder;
use Carbon\Carbon;

class WONumberService
{
    /**
     * Generate next Work Order number using the legacy format
     * Format: PREFIX + 00 + 20 + SEQUENCE + T
     * Example: 86 + 00 + 20 + 01 + T = 86002001T
     */
    public static function generateNextNumber(): string
    {
        $prefix = Setting::getWOPrefix();

        // Get the last WO number
        $lastWO = WorkOrder::orderBy('wo_number', 'desc')->first();

        if ($lastWO) {
            // Extract sequence number from last WO (2 digits before T)
            $lastSequence = (int) substr($lastWO->wo_number, -2);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        // Legacy format: PREFIX + 00 + 20 + SEQUENCE + T
        // Example: 86 + 00 + 20 + 01 + T = 86002001T
        return $prefix . '00' . '20' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT) . 'T';
    }

    /**
     * Generate next Work Order number with custom format
     */
    public static function generateNextNumberWithFormat(string $format = null): string
    {
        $prefix = Setting::getWOPrefix();

        // Get the last WO number
        $lastWO = WorkOrder::orderBy('wo_number', 'desc')->first();

        if ($lastWO) {
            // Extract sequence number from last WO (2 digits before T)
            $lastSequence = (int) substr($lastWO->wo_number, -2);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        if ($format === 'T') {
            // Format with T suffix: 86 + 00 + 20 + 01 + T = 86002001T
            return $prefix . '00' . '20' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT) . 'T';
        }

        // Default format: PREFIX + 00 + 20 + SEQUENCE
        return $prefix . '00' . '20' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Generate next Work Order number using the previous format
     * Format: PREFIX + YEAR + MONTH + SEQUENCE + SUFFIX
     * Example: 86 + 00 + 20 + 01 + T = 86002001T
     */
    public static function generateLegacyFormat(): string
    {
        $prefix = Setting::getWOPrefix();

        // Get the last WO number
        $lastWO = WorkOrder::orderBy('wo_number', 'desc')->first();

        if ($lastWO) {
            // Extract sequence number from last WO (2 digits before T)
            $lastSequence = (int) substr($lastWO->wo_number, -2);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        // Legacy format: PREFIX + 00 + 20 + SEQUENCE + T
        // Example: 86 + 00 + 20 + 01 + T = 86002001T
        return $prefix . '00' . '20' . str_pad($nextSequence, 2, '0', STR_PAD_LEFT) . 'T';
    }

    /**
     * Validate WO number format
     */
    public static function validateFormat(string $woNumber): bool
    {
        $prefix = Setting::getWOPrefix();
        $pattern = "/^{$prefix}00\d{4}T$/";

        return preg_match($pattern, $woNumber) === 1;
    }

    /**
     * Get WO number components
     */
    public static function parseWONumber(string $woNumber): array
    {
        $prefix = Setting::getWOPrefix();
        $hasTSuffix = substr($woNumber, -1) === 'T';

        if ($hasTSuffix) {
            $woNumber = substr($woNumber, 0, -1);
        }

        $year = substr($woNumber, strlen($prefix), 2);
        $month = substr($woNumber, strlen($prefix) + 2, 2);
        $sequence = substr($woNumber, strlen($prefix) + 4);

        return [
            'prefix' => $prefix,
            'year' => '20' . $year,
            'month' => $month,
            'sequence' => (int) $sequence,
            'has_tsuffix' => $hasTSuffix,
        ];
    }
}
