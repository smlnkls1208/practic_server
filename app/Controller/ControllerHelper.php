<?php

namespace Controller;

use Src\Validator\Validator;

trait ControllerHelper
{
    private function formatErrors(Validator $validator): array
    {
        $messages = [];

        foreach ($validator->errors() as $field => $fieldErrors) {
            $messages[$field] = $this->translateFieldNames((string)$fieldErrors[0]);
        }

        return $messages;
    }

    private function translateFieldNames(string $message): string
    {
        return str_replace([
            'login',
            'password',
            'role_id',
            'surname',
            'name',
            'patronym',
            'birth_date',
            'position_id',
            'specialization_id',
            'patient_id',
            'doctor_id',
            'appointment_at',
        ], [
            'логин',
            'пароль',
            'роль',
            'фамилия',
            'имя',
            'отчество',
            'дата рождения',
            'должность',
            'специализация',
            'пациент',
            'врач',
            'дата и время приема',
        ], $message);
    }
}
