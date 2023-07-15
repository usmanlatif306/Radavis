<?php

namespace App\Services;

use App\Models\dispatch;
use Carbon\Carbon;

class CalendarService
{
    public static function getMonth($month): string
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        return array_search($month, $months);
    }

    public static function months(): array
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $currenct_month = str_replace('0', '', date('m'));
        return array_slice($months, 0, $currenct_month, true);
    }

    public static function years(): array
    {
        $oldest_record = dispatch::oldest('date')->first();
        $oldest_year = Carbon::createFromTimestamp($oldest_record->date)->format('Y');
        return range(date('Y'), $oldest_year);
    }
}
