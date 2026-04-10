<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'surname',
        'name',
        'patronym',
        'birth_date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}