<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function schedule(AppointmentRequest $request)
    {
        $appointment = new Appointment();
        $post_request = $request->validated();

        $data = $appointment->create($post_request);

        if ($data)
        {
            $message = 'Appointment successfully scheduled.';
            $type = 'success';
        }
        else
        {
            $message = 'Unable to schedule an appointment. Please try again.';
            $type = 'error';
        }

        return back()->with('data', $data)
            ->with('message', $message)
            ->with('type', $type);
    }
}
