<?php

namespace App\Utils;

use App\Models\Candidate;
use Carbon\Carbon;

class ContentParser
{
    public static function parse(string $content, Candidate $candidate, \DateTime $appointmentDate = null, $user = null)
    {
        $mapping = [
            '%%JOB_TITLE%%'                => $candidate->recruitment->job_title,
            '%%CANDIDATE_NAME%%'           => $candidate->name,
            '%%USER_FIRST_NAME%%'          => $user ? $user->name : '',
            '%%USER_LAST_NAME%%'           => '',
            '%%APPOINTMENT_NATURAL_DATE%%' => $appointmentDate ? self::naturalDate($appointmentDate) : '',
            '%%APPOINTMENT_DATE%%'         => $appointmentDate ? self::formattedDate($appointmentDate) : '',
            '%%APPOINTMENT_TIME%%'         => $appointmentDate ? $appointmentDate->format('G:i') : '',
        ];

        foreach ($mapping as $variable => $value) {
            $content = str_replace($variable, $value, $content);
        }

        return $content;
    }

    protected static function naturalDate($date)
    {
        $prefix = '';
        $carbonDate = Carbon::instance($date)->locale('pl_PL');
        $carbonDateYesterday = $carbonDate->copy();

        if ($carbonDate->isTomorrow()) {
            $prefix = 'jutro, tj. ';
        } elseif ($carbonDateYesterday->subDay(1)->isTomorrow()) {
            $prefix = 'pojutrze, tj. ';
        }

        return $prefix.$carbonDate->isoFormat('dddd, D MMMM');
    }

    protected static function formattedDate($date)
    {
        $carbonDate = Carbon::instance($date)->locale('pl_PL');

        return $carbonDate->isoFormat('dddd, D MMMM');
    }
}
