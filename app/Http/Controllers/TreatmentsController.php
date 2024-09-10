<?php

namespace App\Http\Controllers;

use App\Models\Supplies;
use App\Models\Treatments;
use App\Models\TreatmentsComponents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreatmentsController extends Controller
{
    //
    public function index()
    {
        $branch = Auth::user()->branches[0];
        $supplies = Supplies::where('branch_id',$branch->id)->get();

        $treatments = Treatments::with('components.supplies.itemsStock')->where('branch_id', $branch->id)->get();
        // dd($treatments[0]->components);
        return view('pages.treatments.index', compact('treatments','supplies'));
    }

    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'supply_id' => 'required|array', // Validate treatment IDs as an array
            'supply_id.*' => 'exists:supplies,id', // Ensure each treatment ID exists
            'qty' => 'required|array', // Validate treatment IDs as an array
            'qty.*' => 'numeric|min:0', // Ensure quantities are numeric and non-negative
        ]);

        if (count($validatedData['supply_id']) !== count($validatedData['qty'])) {
            return redirect()->back()->with('error', 'Mismatch between supplies and quantities.');
        }


        $branch = Auth::user()->branches[0];
        $treatments = Treatments::create([
            'branch_id' => $branch->id,
            'name' => $request->name,
            'price' => $request->price
        ]);


        foreach ($validatedData['supply_id'] as $index => $supplyId) {
            $quantity = $validatedData['qty'][$index];

            TreatmentsComponents::create([
                'treatment_id' => $treatments->id,
                'supply_id' => $supplyId,
                'qty' => $quantity,
            ]);
        }

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Treatment Created.',
        ]);

        return redirect()->route('treatments.index');

    }
}
