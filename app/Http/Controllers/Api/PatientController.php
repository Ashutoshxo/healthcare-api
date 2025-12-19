<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = Patient::create($request->validated());

        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient,
        ], 201);
    }

  
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $patients = Patient::query()
            ->when($search, function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($patients);
    }

   
    public function show(int $id): JsonResponse
    {
        $patient = Patient::with([
            'appointments' => function ($query) {
                $query->latest()->limit(5);
            }
        ])->find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json($patient);
    }
}
