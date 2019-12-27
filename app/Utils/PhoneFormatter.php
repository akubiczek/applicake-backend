<?php

namespace App\Utils;

use McCool\LaravelAutoPresenter\BasePresenter;
use Carbon\Carbon;

class PhoneFormatter
{
    public static function format($phoneNumber)
    {
        $phoneNumber = preg_replace("/[^0-9]/", '', $phoneNumber);
        $len = strlen($phoneNumber);
        return substr($phoneNumber, 0,$len-6 )." ".substr($phoneNumber, $len-6,3 )." ".substr($phoneNumber, $len-3);
    }
//
//    public function created_at()
//    {
//        return $this->formatDate($this->wrappedObject->created_at);
//    }
//
//    public function updated_at()
//    {
//        return $this->formatDate($this->wrappedObject->updated_at);
//    }
//
//    public function updated_at_daysdiff()
//    {
//        $updated_at = $this->wrappedObject->updated_at;
//        $now = Carbon::now('Europe/Warsaw');
//
//        $daysDiff = $updated_at->diffInDays($now);
//
//        return $daysDiff;
//    }
//
//    protected function formatDate(\DateTime $date)
//    {
//        $now = Carbon::now('Europe/Warsaw')->endOfDay();
//
//        $daysDiff = $date->diffInDays($now);
//
//        if ($daysDiff == 0) {
//            return 'Dzisiaj, '.$date->format('H:i');
//        }
//        elseif ($daysDiff == 1) {
//            return 'Wczoraj, '.$date->format('H:i');
//        }
//        elseif ($daysDiff < 14) {
//            return $daysDiff.' dni temu ';
//        }
//
//        return Carbon::createFromFormat('Y-m-d H:i:s', $date)
//            ->toFormattedDateString();
//    }
}
