<?php

namespace Controller;

use Model\Doctor;
use Model\Position;
use Model\Specialization;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class DoctorController
{
    use ControllerHelper;

    public function index(Request $request): string
    {
        $search = trim((string)$request->get('search', ''));
        $query = Doctor::with(['position', 'specialization']);

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('surname', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('patronym', 'like', '%' . $search . '%')
                    ->orWhereHas('position', function ($relation) use ($search) {
                        $relation->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('specialization', function ($relation) use ($search) {
                        $relation->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'surname' => ['required'],
                'name' => ['required'],
                'position_id' => ['required'],
                'specialization_id' => ['required'],
                'birth_date' => ['required'],
            ]);

            $errors = $this->formatErrors($validator);

            if (!empty($errors)) {
                return new View('site.doctors', [
                    'doctors' => $query->orderBy('surname')->orderBy('name')->get(),
                    'positions' => Position::query()->orderBy('name')->get(),
                    'specializations' => Specialization::query()->orderBy('name')->get(),
                    'search' => $search,
                    'errors' => $errors,
                    'old' => $request->all(),
                ]);
            }

            Doctor::create([
                'surname' => (string)$request->get('surname', ''),
                'name' => (string)$request->get('name', ''),
                'patronym' => (string)$request->get('patronym', ''),
                'position_id' => (int)$request->get('position_id', 0),
                'specialization_id' => (int)$request->get('specialization_id', 0),
                'birth_date' => (string)$request->get('birth_date', ''),
            ]);

            app()->route->redirect('/doctors');
            return '';
        }

        return new View('site.doctors', [
            'doctors' => $query->orderBy('surname')->orderBy('name')->get(),
            'positions' => Position::query()->orderBy('name')->get(),
            'specializations' => Specialization::query()->orderBy('name')->get(),
            'search' => $search,
        ]);
    }
}
