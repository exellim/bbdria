<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\AppointmentsDetails;
use App\Models\AppointmentTreatments;
use App\Models\Customers;
use App\Models\SuppliesOut;
use App\Models\SuppliesStock;
use App\Models\TreatmentsComponents;
use App\Models\User;
use Carbon\Carbon;
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

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['doctor', 'beautician', 'assistant doctor']);
        })->get();
        $cost = 0;

        foreach ($appointments[0]->details as $key => $value) {
            $cost += $value->treatment->price;
        }



        // $details = AppointmentsDetails::with('treatment.components')->where('receipt_code',$appointments[0]->receipt_code)->get();

        // dd($appointments[0]->details[0]->treatment);

        return view('pages.appointments.finish', compact('appointments','cost','users'));
    }

    public function store(Request $request, $receipt_code)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'supply_id' => 'required|array', // Validate treatment IDs as an array
            'supply_id.*' => 'exists:supplies,id', // Ensure each treatment ID exists
            'qty' => 'required|array', // Validate treatment IDs as an array
            'qty.*' => 'numeric|min:0', // Ensure quantities are numeric and non-negative
        ]);


        // $customerValue = $request->id_customer;

        // $customer = Customers::where('id', $customerValue)->get();

        foreach ($validatedData['supply_id'] as $index => $supplyId) {
            $quantity = $validatedData['qty'][$index];
            // $supplies = SuppliesStock::where('supply_id', $supplyId)->first();

            // dd($supplies);
            $oldSuppliesStock = SuppliesStock::where('supply_id',$supplyId)->first();

            AppointmentTreatments::create([
                'receipt_code' => $receipt_code,
                'supply_id' => $supplyId,
                'supply_qty' => $quantity,
            ]);
            // $supplies->update([
            //     'qty' => $supplies->qty - $quantity
            // ]);

            SuppliesStock::where('supply_id', $supplyId)
            ->update(['qty' => $oldSuppliesStock->qty - $quantity]);
        }

        Appointments::where('receipt_code', $receipt_code)->update(['status' => 'finish']);



        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Supply Created.',
        ]);

        return redirect()->route('appointments.index');

    }
}
