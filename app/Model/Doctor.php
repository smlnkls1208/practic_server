<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'surname',
        'name',
        'patronym',
        'position_id',
        'specialization_id',
        'birth_date',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}