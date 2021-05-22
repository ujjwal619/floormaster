<?php


use Carbon\Carbon;

if (!function_exists('getFiscalYear')) {
    function getFiscalYear($when='start', $startMonth=7) {
        $newDate =  Carbon::now();
        $date = Carbon::parse($newDate)->month($startMonth);
        $startDate = $date->firstOfMonth();
        if ($newDate->diffInMilliseconds($date, FALSE) > 0) {
            $startDate = $date->subMonth(12);
        }
        $copyStartDate = $startDate->copy();
        $endDate = $copyStartDate->addMonth(11)->endOfMonth();

        if (!$when) {
            return [
                $startDate->toDateString(),
                $endDate->toDateString()
            ];
        }
      
        return $when == 'start' ? $startDate->toDateString() : $endDate->toDateString();
      }
}

// if (!function_exists('getFiscalYearDateRangeForValidation')) {
//     function getFiscalYearDateRangeForValidation() {
//         $startDate = getFiscalYear();
//         $endDate = getFiscalYear('end');
//         return [

//           formatDate(moment(startDate).subtract(1, 'days')),
//           formatDate(moment(endDate).add(1, 'days'))
//         ];
//     }
// }
  
if (!function_exists('getCurrentMonth')) {
    function getCurrentMonth($when = 'start') {
        $newDate =  Carbon::now();
        $startOfMonth = $newDate->startOfMonth()->toDateString();
        $endOfMonth = $newDate->endOfMonth()->toDateString();

        if (!$when) {
            return [
                $startOfMonth,
                $endOfMonth
            ];
        }

        return $when == 'start' ? $startOfMonth : $endOfMonth;
    }
}

if (!function_exists('getDateRangeForValidation')) {
    function getDateRangeForValidation($isSuperUser = false, $when = '') {
        return $isSuperUser ? getFiscalYear($when) : getCurrentMonth($when);
    }
}

if (!function_exists('getDateRange')) {
    function getDateRange($isSuperUser = false, $when = '') {
        return $isSuperUser ? getFiscalYear($when) : getCurrentMonth($when);
    }
}
  
//   export function getMonthRangeForValidation() {
//     $startDate = getCurrentMonth();
//     $endDate = getCurrentMonth('end');
//     return [
//       formatDate(moment(startDate).subtract(1, 'days')),
//       formatDate(moment(endDate).add(1, 'days'))
//     ];
//   }

if (!function_exists('getAmountWithSign')) {
    function getAmountWithSign($amount, $sign) {
        $result = 0;
        switch($sign) {
            case '+':
                $result = abs($amount);
            break;
            case '-':
                $result = -abs($amount);
            break;
        }
        
        return $result;
    }
}

if (!function_exists('numberFormatPrecision')) {
    function numberFormatPrecision($number, $precision = 2, $separator = '.')
    {
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];
        if (count($numberParts)>1 && $precision > 0) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }
}
