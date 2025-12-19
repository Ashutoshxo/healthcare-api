<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentStatusRequest;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
       
        $exists = Appointment::where('patient_id', $request->patient_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Appointment slot already booked for this patient'
            ], 422);
        }

        $appointment = Appointment::create([
            ...$request->validated(),
            'status' => 'booked',
        ]);

        return response()->json([
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ], 201);
    }

    
    public function index(Request $request): JsonResponse
    {
        $appointments = Appointment::query()
            ->when($request->date, fn ($q) =>
                $q->whereDate('appointment_date', $request->date)
            )
            ->when($request->status, fn ($q) =>
                $q->where('status', $request->status)
            )
            ->orderBy('appointment_date')
            ->paginate(10);

        return response()->json($appointments);
    }

    public function updateStatus(
        UpdateAppointmentStatusRequest $request,
        int $id
    ): JsonResponse {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }

        $appointment->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Appointment status updated',
            'data' => $appointment,
        ]);
    }

   
    public function destroy(int $id): JsonResponse
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ]);
    }
}
