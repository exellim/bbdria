<?php

namespace App\Http\Controllers;

use App\Models\AppointmentPic;
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

        $branch = Auth::user()->branches[0]->id;

        $appointments = Appointments::with('customer','details.treatment.components.supplies','pics.user')
        ->where('id',$id)
        ->get();

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['doctor', 'beautician', 'assistant']);
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
        // dd($request->all());
        $validatedData = $request->validate([
            'supply_id' => 'required|array', // Validate supply IDs as an array
            'supply_id.*' => 'exists:supplies,id', // Ensure each supply ID exists in the supplies table
            'user_id' => function ($attribute, $value, $fail) use ($request) {
                // Check if at least one Doctor or Beautician is selected
                $doctorSelected = false;
                $beauticianSelected = false;

                foreach ($request->user_id as $userId) {
                    $user = \App\Models\User::find($userId);
                    if ($user && $user->roles->contains('name', 'doctor')) {
                        $doctorSelected = true;
                    }
                    if ($user && $user->roles->contains('name', 'beautician')) {
                        $beauticianSelected = true;
                    }
                }

                if (!$doctorSelected && !$beauticianSelected) {
                    $fail('You must select at least one Doctor or Beautician.');
                }
            },
            'qty' => 'required|array', // Validate quantities as an array
            'qty.*' => 'numeric|min:0', // Ensure each quantity is numeric and non-negative
        ]);

        // $customerValue = $request->id_customer;

        // $customer = Customers::where('id', $customerValue)->get();

        foreach ($validatedData['supply_id'] as $index => $supplyId) {
            $quantity = $validatedData['qty'][$index];
            $oldSuppliesStock = SuppliesStock::where('supply_id',$supplyId)->first();

            AppointmentTreatments::create([
                'receipt_code' => $receipt_code,
                'supply_id' => $supplyId,
                'supply_qty' => $quantity,
            ]);

            SuppliesStock::where('supply_id', $supplyId)
            ->update(['qty' => $oldSuppliesStock->qty - $quantity]);
        }

        foreach ($validatedData['user_id'] as $uid) {
            if (!is_null($uid)) { // Check if user_id is not null
                AppointmentPic::create([
                    'receipt_code' => $receipt_code,
                    'users_id' => $uid,
                ]);
            }
        }


        $branchname = Auth::user()->branches[0]->name;

        // Get the file extension
        // $extension = 'png';
        // Create a filename using the request name and the extension
        // $fileName = $receipt_code . '.' . $extension;
        // Store the image with the new name

        // $cust = Appointments::with('customer','details.treatment.components.supplies','pics.user')->where('receipt_code', $receipt_code)->get();
        // dd($cust[0]->customer->name);

        // $imagePath = $request->file('image')->storeAs();

        // $url = route('review', $receipt_code); // Your URL here
        // $qrPath = storage_path('images/'. $branchname.'/'.'treatment-complete/'.$receipt_code.'/', $fileName, 'public'); // Custom path to save QR code image


        Appointments::where('receipt_code', $receipt_code)->update(['status' => 'finish']);



        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Supply Created.',
        ]);

        return redirect()->route('appointments.index');

    }

    public function reviews( $receipt_code)
    {

        $pics = Appointments::with('customer','details.treatment.components.supplies','pics.user')->where('receipt_code',$receipt_code)
        ->get();
        if ($pics[0]->pics[0]->review != 0) {
            $cust = Appointments::with('customer','details.treatment.components.supplies','pics.user')->where('receipt_code',$receipt_code)
            ->get();
            return view('pages.appointments.thanks',compact('cust'));
        } else {
            return view('pages.appointments.review', compact('pics'));
        }

        // dd();

        // dd($pics[0]);

        // AppointmentPic::where('receipt_code', $receipt_code)->update([
        //     ''
        // ]);

    }

    public function storeReviews(Request $request, $receipt_code)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'id_pic' => 'required|array', // Validate treatment IDs as an array
            'id_pic.*' => 'exists:users,id', // Ensure each treatment ID exists
            'review' => 'required|array', // Validate treatment IDs as an array
            'review.*' => 'string', // Ensure each treatment ID exists
            'review_pic' => 'required|array', // Validate treatment IDs as an array
            'review_pic.*' => 'string', // Ensure each treatment ID exists
        ]);

        $cust = Appointments::with('customer','details.treatment.components.supplies','pics.user')->where('receipt_code',$receipt_code)
        ->get();

        foreach ($validatedData['id_pic'] as $index => $review) {
            AppointmentPic::where('receipt_code', $receipt_code)->where('users_id',$review)
            ->update([
                'review' => $validatedData['review'][$index],
                'description' => $validatedData['review_pic'][$index],
            ]);
        }

        return view('pages.appointments.thanks',compact('cust'));

    }
}
