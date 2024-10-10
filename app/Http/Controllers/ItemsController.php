<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Items;
use App\Models\ItemsOut;
use App\Models\ItemsOutDetails;
use App\Models\ItemsStock;
use Carbon\Carbon;
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

    public function itemIn(){

    }
    public function cashier(){
        $branch = Auth::user()->branches[0]->id;

        $items = Items::with('category','itemsStock')->where('branch_id', $branch)->get();

        return view('pages.cashier.index', compact('items'));
    }

    public function cashierst(Request $request)
    {
        $branch = Auth::user()->branches[0];
        $numAppointment = count(ItemsOut::where('branch_id',$branch->id)->get());
        $appointmentNumber = str_pad($numAppointment + 1, 4, '0', STR_PAD_LEFT);
        $date = Carbon::now(); // Get the current date
        $formattedDate = $date->format('dmy'); // e.g., 110524
        $receiptCode = 'IT-'.$appointmentNumber .'-'. $branch->abbreviation .'-'. $formattedDate;

        // dd(preg_replace('/,/', '', $request->grand_total), $receiptCode);
        // dd($request->all(), $receiptCode);

        $validatedData = $request->validate([
            'item_ids' => 'required|array', // Validate treatment IDs as an array
            'item_ids.*' => 'exists:items,id', // Ensure each treatment ID exists
            'quantities' => 'required|array', // Validate treatment IDs as an array
            'quantities.*' => 'numeric|min:1', // Ensure each treatment ID exists
            'prices' => 'required|array', // Validate treatment IDs as an array
            'prices.*' => 'min:1', // Ensure each treatment ID exists
        ]);

        ItemsOut::create([
            'branch_id' => $branch->id,
            'receipt_code' => $receiptCode,
            'date' => $date,
            'total_price' => preg_replace('/,/', '', $request->grand_total)
        ]);

        foreach ($validatedData['item_ids'] as $index => $item) {
            $quantity = $validatedData['quantities'][$index];
            $priceFormt = preg_replace('/,/', '', $validatedData['prices'][$index]);

            ItemsOutDetails::create([
                'receipt_code' => $receiptCode,
                'item_id' => $item,
                'qty' => $quantity,
                'price' => $priceFormt
            ]);
        }

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Sales has been made!.',
        ]);

        return redirect()->route('cashier.index');

    }
}
