<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function create($data)
    {
        $schedule = new Schedule();

        $days = $schedule->checkDay($data['day']);
        $data['date'] = Carbon::parse($data['date'])->format('Y-m-d');
        $data['time'] = json_encode($data['time']);

        $post_data = array_merge($days, $data);
        $modelSchedule = $schedule->create($post_data);

        $model = new static();
        $model->schedule_id = $modelSchedule->id;
        $model->notes = $data['note'];

        return $model->save();
    }
}
