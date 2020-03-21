<?php


namespace App\Utils;


use App\Models\Candidate;
use Carbon\Carbon;

class ContentParser
{
    public static function parse(string $content, Candidate $candidate, \DateTime $appointmentDate = null)
    {
        $mapping = [
            '%%JOB_TITLE%%' => $candidate->recruitment->name,
            '%%CANDIDATE_FIRST_NAME%%' => $candidate->first_name,
            '%%CANDIDATE_LAST_NAME%%' => $candidate->last_name,
            '%%APPOINTMENT_DATE%%' => $appointmentDate ? self::richDateFormat($appointmentDate) : '',
            '%%APPOINTMENT_TIME%%' => $appointmentDate ? $appointmentDate->format('G:i') : '',
        ];

        foreach ($mapping as $variable => $value) {
            $content = str_replace($variable, $value, $content);
        }

        return $content;
    }

    protected static function richDateFormat($date)
    {
        $prefix = '';
        $carbonDate = Carbon::instance($date)->locale('pl_PL');
        $carbonDateYesterday = $carbonDate->copy();

        if ($carbonDate->isTomorrow()) {
            $prefix = 'jutro, tj. ';
        } else if ($carbonDateYesterday->subDay(1)->isTomorrow()) {
            $prefix = 'pojutrze, tj. ';
        }

        return $prefix . $carbonDate->isoFormat('dddd, D MMMM');
    }
}
