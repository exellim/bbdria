<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\AppointmentsDetails;
use App\Models\TreatmentsComponents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartTreatmentController extends Controller
{
    //
    public function index($id)
    {
        $appointments = Appointments::with('customer','details.treatment.components.supplies')
        ->where('id',$id)
        ->get();

        // $details = AppointmentsDetails::with('treatment.components')->where('receipt_code',$appointments[0]->receipt_code)->get();

        // dd($appointments[0]->details[0]->treatment);

        return view('pages.appointments.finish', compact('appointments'));
    }
}
