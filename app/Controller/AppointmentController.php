<?php

namespace Controller;

use Model\Appointment;
use Model\Doctor;
use Model\Patient;
use Src\Request;
use Src\View;

class AppointmentController
{
    public function index(Request $request): string
    {
        $patientId = (int)$request->get('patient_id', 0);
        $doctorId = (int)$request->get('doctor_id', 0);
        $appointmentDate = trim((string)$request->get('appointment_date', ''));

        $query = Appointment::with(['patient', 'doctor']);

        if ($patientId > 0) {
            $query->where('patient_id', $patientId);
        }

        if ($doctorId > 0) {
            $query->where('doctor_id', $doctorId);
        }

        if ($appointmentDate !== '') {
            $query->whereDate('appointment_at', $appointmentDate);
        }

        if ($request->method === 'POST') {
            Appointment::create([
                'patient_id' => (int)$request->get('patient_id', 0),
                'doctor_id' => (int)$request->get('doctor_id', 0),
                'appointment_at' => str_replace('T', ' ', (string)$request->get('appointment_at', '')),
            ]);

            app()->route->redirect('/appointments');
            return '';
        }

        return new View('site.appointments', [
            'appointments' => $query->orderBy('appointment_at', 'desc')->get(),
            'patients' => Patient::query()->orderBy('surname')->orderBy('name')->get(),
            'doctors' => Doctor::query()->orderBy('surname')->orderBy('name')->get(),
            'filters' => [
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'appointment_date' => $appointmentDate,
            ],
        ]);
    }

    public function cancel(Request $request): void
    {
        $appointmentId = (int)$request->get('appointment_id', 0);

        if ($appointmentId > 0) {
            Appointment::query()->where('id', $appointmentId)->delete();
        }

        app()->route->redirect('/appointments');
    }
}
