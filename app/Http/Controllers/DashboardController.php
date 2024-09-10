<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Items;
use App\Models\Supplies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        $branch = Auth::user()->branches[0]->id;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $appointments = Appointments::with('customer', 'details.treatment')
            ->where('branch_id', $branch)
            ->whereMonth('appointment_date', $currentMonth)
            ->whereYear('appointment_date', $currentYear)
            ->get();

        $items = Items::with('category','branch','itemsStock')->where('branch_id',$branch)->get();
        $supplies = Supplies::with('itemsStock','branch')->where('branch_id',$branch)->get();

        $suppliesExpenses = 0;
        // Initialize total sum
        $appointmentProfit = 0;

        // Iterate over each appointment
        foreach ($appointments as $appointment) {
            // Iterate over each detail in the appointment
            foreach ($appointment->details as $detail) {
                // Access the treatment price and add to the total sum
                $appointmentProfit += $detail->treatment->price;
            }
        }

       // Iterate over each supply
       foreach ($supplies as $supply) {
        // Iterate over each itemStock in the supply
        foreach ($supply->itemsStock as $key=>$itemStock) {
            // Calculate cost: hpp * qty
            $suppliesExpenses += $supply->hpp * $itemStock->qty;
            // dd($suppliesExpenses,$supply->hpp, $itemStock->qty);
        }
    }

        // dd($suppliesExpenses);

        return view('dashboard',compact('appointmentProfit','suppliesExpenses'));
    }
}
