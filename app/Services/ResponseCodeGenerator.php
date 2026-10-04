<?php

namespace App\Services;

use App\Models\Response;
use Illuminate\Support\Facades\DB;

class ResponseCodeGenerator
{
    public static function generate(string $prefix = 'INV-KAL'): string
    {
        $year = date('Y');
        $prefixWithYear = "{$prefix}-{$year}-";

        // Get count of responses for current year
        $latest = DB::table('responses')
            ->where('response_code', 'LIKE', "{$prefixWithYear}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($latest) {
            $lastNum = (int) substr($latest->response_code, -5);
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        return $prefixWithYear . str_pad((string) $newNum, 5, '0', STR_PAD_LEFT);
    }
}
