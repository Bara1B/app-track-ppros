<?php

namespace App\Helpers;

class NotificationHelper
{
    /**
     * Show success notification
     */
    public static function success($message)
    {
        session()->flash('success', $message);
    }

    /**
     * Show error notification
     */
    public static function error($message)
    {
        session()->flash('error', $message);
    }

    /**
     * Show warning notification
     */
    public static function warning($message)
    {
        session()->flash('warning', $message);
    }

    /**
     * Show info notification
     */
    public static function info($message)
    {
        session()->flash('info', $message);
    }

    /**
     * Show notification based on operation result
     */
    public static function operation($success, $successMessage, $errorMessage = null)
    {
        if ($success) {
            self::success($successMessage);
        } else {
            self::error($errorMessage ?? 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Show CRUD operation notifications
     */
    public static function created($itemName = 'Data')
    {
        self::success("{$itemName} berhasil ditambahkan!");
    }

    public static function updated($itemName = 'Data')
    {
        self::success("{$itemName} berhasil diperbarui!");
    }

    public static function deleted($itemName = 'Data')
    {
        self::success("{$itemName} berhasil dihapus!");
    }

    public static function verified($itemName = 'Data')
    {
        self::success("{$itemName} berhasil diverifikasi!");
    }

    public static function imported($itemName = 'Data')
    {
        self::success("{$itemName} berhasil diimpor!");
    }

    public static function exported($itemName = 'Data')
    {
        self::success("{$itemName} berhasil diekspor!");
    }
}


