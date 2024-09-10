<?php

namespace App\Http\Controllers;

use App\Models\Supplies;
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
        ]);

        $supplyStock = SuppliesStock::create([
            'supply_id' => $supply->id,
            'qty'=>0,
            'units'=>$request->units,
        ]);


        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Supply Created.',
        ]);

        return redirect()->route('supplies.index');
    }
}
