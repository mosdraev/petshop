<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'has_monday',
        'has_tuesday',
        'has_wednesday',
        'has_thursday',
        'has_friday',
        'has_saturday',
        'has_sunday',
        'date',
        'time',
        'frequency'
    ];

    public function checkDay($days)
    {
        $reference = [
            'has_monday'    => 'mon',
            'has_tuesday'   => 'tue',
            'has_wednesday' => 'wed',
            'has_thursday'  => 'thu',
            'has_friday'    => 'fri',
            'has_saturday'  => 'sat',
            'has_sunday'    => 'sun'
        ];

        foreach ($reference as $key => $value)
        {
            if (in_array($value, $days))
            {
                $reference[$key] = 1;
            }
            else
            {
                $reference[$key] = 0;
            }
        }

        return $reference;
    }
}
