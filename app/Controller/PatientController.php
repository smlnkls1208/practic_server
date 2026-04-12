<?php

namespace Controller;

use Model\Patient;
use Src\Request;
use Src\View;

class PatientController
{
    public function index(Request $request): string
    {
        $search = trim((string)$request->get('search', ''));
        $query = Patient::query();

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('surname', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('patronym', 'like', '%' . $search . '%');
            });
        }

        if ($request->method === 'POST') {
            Patient::create([
                'surname' => (string)$request->get('surname', ''),
                'name' => (string)$request->get('name', ''),
                'patronym' => (string)$request->get('patronym', ''),
                'birth_date' => (string)$request->get('birth_date', ''),
            ]);

            app()->route->redirect('/patients');
            return '';
        }

        return new View('site.patients', [
            'patients' => $query->orderBy('surname')->orderBy('name')->get(),
            'search' => $search,
        ]);
    }
}
