<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Supplies;
use App\Models\SuppliesOut;
use App\Models\SuppliesStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuppliesController extends Controller
{
    //
    public function index()
    {
        $branch = Auth::user()->branches[0];
        // dd(Auth::user());
        $supplies = Supplies::with('itemsStock','branch')->where('branch_id',$branch->id)->get();

        // dd($supplies);
        return view('pages.items.supplies.index', compact('supplies'));
    }

    public function in(){
        return view('pages.supplies.in');
    }

    public function out(){
        $branch = Auth::user()->branches[0];

        $appointments = Appointments::with('customer','details.treatment.components.supplies')->where('branch_id',$branch->id)->where('status','finish')->latest()->get();
        $supplies = SuppliesOut::where('branch_id', $branch->id)->get();
        return view('pages.supplies.out', compact('appointments','supplies'));
    }

    public function store(Request $request)
    {

        $branch = Auth::user()->branches[0]->id;
        $branchname = Auth::user()->branches[0]->name;

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Create a filename using the request name and the extension
            $fileName = $request->name . '.' . $extension;
            // Store the image with the new name
            $imagePath = $request->file('image')->storeAs('images/'. $branchname.'/'.'supplies/'.$request->name, $fileName, 'public');
        }

        $supply = Supplies::create([
            'branch_id' => $branch,
            'name' => $request->name,
            'description' => $request->description,
            'hjl' => $request->hjl,
            'hpp' => $request->hpp,
            'image' => $imagePath,
            'reminder' => $request->reminder,
        ]);

        $supplyStock = SuppliesStock::create([
            'supply_id' => $supply->id,
            'qty'=>0,
            'capacity'=> $request->capacity ? $request->capacity : '0',
            'units'=>$request->units,
        ]);


        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Supply Created.',
        ]);

        return redirect()->route('supplies.index');
    }

    public function update(Request $request, $id){
        // Retrieve branch information
        $branch = Auth::user()->branches[0]->id;
        $branchname = Auth::user()->branches[0]->name;

        // Retrieve the supply record from the database
        $supply = Supplies::find($id);
        $supplyStock = SuppliesStock::where('supply_id',$id)->first();

        // Handle image upload (if a new image is uploaded)
        if ($request->hasFile('image')) {
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Create a filename using the request name and the extension
            $fileName = $request->name . '.' . $extension;
            // Store the image with the new name
            $imagePath = $request->file('image')->storeAs('images/'. $branchname.'/'.'supplies/'.$request->name, $fileName, 'public');

            // Update the supply's image path only if a new image is uploaded
            $supply->image = $imagePath;
        }

        // Update other fields
        $supply->name = $request->input('name');
        $supply->description = $request->input('description');
        $supply->hjl = $request->input('hjl');
        $supply->hpp = $request->input('hpp');

        // Save the updated supply
        $supply->save();

        $supplyStock->capacity = $request->input('capacity');
        $supplyStock->units = $request->input('units');
        $supplyStock->reminder = $request->input('reminder');
        $supplyStock->save();
        // 'supply_id' => $supply->id,
        // 'qty'=>0,
        // 'capacity'=> $request->capacity ? $request->capacity : '0',
        // 'units'=>$request->units,

        // Set a success message in session
        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Supply Updated.',
        ]);

        // Redirect to the index page or wherever needed
        return redirect()->route('supplies.index');
    }
}
