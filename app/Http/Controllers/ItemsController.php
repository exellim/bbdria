<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Items;
use App\Models\ItemsStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    //
    public function index()
    {
        $branch = Auth::user()->branches[0]->id;

        $category = Categories::where('branch_id',$branch)->get();

        $items = Items::with('category','branch','itemsStock')->where('branch_id',$branch)->get();

        return view('pages.items.items.index', compact('items','category'));
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
            $imagePath = $request->file('image')->storeAs('images/'. $branchname.'/'.'items/'.$request->name, $fileName, 'public');
        }

        $items = Items::create([
            'category_id' => $request->category,
            'branch_id' => $branch,
            'name'=> $request->name,
            'descriptions' => $request->descriptions,
            'expiry_date' => $request->expiry_date,
            'hjl' => $request->hjl,
            'hpp' => $request->hpp,
            'image' => $imagePath
        ]);

        $stock = ItemsStock::create([
            'item_id' => $items->id,
            'qty' => '0'
        ]);


        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Item Created.',
        ]);

        return redirect()->back();
    }
}
