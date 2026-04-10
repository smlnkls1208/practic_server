<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}