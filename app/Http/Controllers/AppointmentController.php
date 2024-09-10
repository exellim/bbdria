<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\AppointmentsDetails;
use App\Models\Customers;
use App\Models\Treatments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    //
    public function index()
    {
        $branch = Auth::user()->branches[0];
        $appointments = Appointments::with('customer','details.treatment')->where('branch_id',$branch->id)->get();
        $customers = Customers::with('branch')->get();
        $treatment = Treatments::where('branch_id',$branch->id)->get();

        // dd($appointments[0]);


        return view('pages.appointments.index', compact('appointments','customers','treatment'));
    }

    public function store(Request $request)
    {
        $branch = Auth::user()->branches[0];
        $numAppointment = count(Appointments::where('branch_id',$branch->id)->get());
        $appointmentNumber = str_pad($numAppointment + 1, 4, '0', STR_PAD_LEFT);
        $date = Carbon::now(); // Get the current date
        $formattedDate = $date->format('dmy'); // e.g., 110524
        $receiptCode = $appointmentNumber .'-'. $branch->abbreviation .'-'. $formattedDate;

        // Validate the request data
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'dp' => 'nullable|string',
            'treatment_id' => 'required|array', // Validate treatment IDs as an array
            'treatment_id.*' => 'exists:treatments,id', // Ensure each treatment ID exists
        ]);

        $dpString = $validatedData['dp'] ?? '';
        $dpValue = preg_replace('/[^\d]/', '', $dpString); // Remove non-numeric characters
        $dpValue = (float) $dpValue; // Convert to float

        // Create a new appointment
        $appointment = Appointments::create([
            'branch_id' => $branch->id,
            'customer_id' => $validatedData['customer_id'],
            'receipt_code' => $receiptCode,
            'appointment_date' => $validatedData['appointment_date'],
            'appointment_time' => $validatedData['appointment_time'],
            'dp' => $dpValue ?? null,  // Optional down payment (nullable)
            'status' => 'waiting',  // Default to 'waiting'
        ]);

        foreach ($validatedData['treatment_id'] as $treatmentId) {
            AppointmentsDetails::create([
                'appointment_id' => $appointment->id, // Associate with the appointment
                'receipt_code' => $receiptCode,
                'treatment_id' => $treatmentId,
            ]);
        }

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Appointment Created.',
        ]);

        return redirect()->back();

    }
}
