<?php

namespace Controller;

use Model\Appointment;
use Model\Doctor;
use Model\Patient;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Api
{
    public function index(): void
    {
        (new View())->toJSON([
            'patients' => Patient::query()->orderBy('surname')->orderBy('name')->get()->toArray(),
            'doctors' => Doctor::with(['position', 'specialization'])->orderBy('surname')->orderBy('name')->get()->toArray(),
            'appointments' => Appointment::with(['patient', 'doctor'])->orderBy('appointment_at', 'desc')->get()->toArray(),
        ]);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        $user = (new User())->attemptIdentity($request->all());

        if (!$user) {
            (new View())->toJSON([
                'message' => 'Неправильные логин или пароль',
            ], 401);
        }

        $token = Auth::attemptToken($request->all());

        if (!$token) {
            (new View())->toJSON([
                'message' => 'Неправильные логин или пароль',
            ], 401);
        }

        (new View())->toJSON([
            'token' => $token,
            'user' => [
                'id' => $user?->id,
                'login' => $user?->login,
                'role' => $user?->role?->name,
            ],
        ]);
    }

    public function appointments(Request $request): void
    {
        $doctorId = (int)$request->get('doctor_id', 0);
        $patientId = (int)$request->get('patient_id', 0);
        $appointmentDate = trim((string)$request->get('appointment_date', ''));

        $query = Appointment::with(['patient', 'doctor']);

        if ($doctorId > 0) {
            $query->where('doctor_id', $doctorId);
        }

        if ($patientId > 0) {
            $query->where('patient_id', $patientId);
        }

        if ($appointmentDate !== '') {
            $query->whereDate('appointment_at', $appointmentDate);
        }

        (new View())->toJSON([
            'appointments' => $query->orderBy('appointment_at', 'desc')->get()->toArray(),
        ]);
    }
}
