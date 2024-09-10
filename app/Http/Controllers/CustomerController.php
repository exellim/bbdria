<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\CustomersGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customers::get();

        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        $customers = Customers::get();

        return view('pages.customers.create', compact('customers'));
    }

    public function galleries($id)
    {
        $customer = Customers::with('galleries')->where('id', $id)->get();

        // dd($customer[0]->galleries[0]);

        return view('pages.customers.gallery', compact('customer'));
    }

    public function galleriesstore(Request $request, $id)
    {
        $branch = Auth::user()->branches[0];
        $customer = Customers::where('id',$id)->get();

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Create a filename using the request name and the extension
            $fileName = $request->name . '.' . $extension;
            // Store the image with the new name
            $imagePath = $request->file('image')->storeAs('images/'. $branch->name.'/'.'customers/'.$customer[0]->name, $fileName, 'public');
        }

        $customer = CustomersGallery::create([
            'customer_id'=>$id,
            'name'=>$request->name,
            'image'=>$imagePath
        ]);

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Image uploaded.',
        ]);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $branch = Auth::user()->branches[0];

        // dd($request->all());

        $imagePath = null;

        // Handle the image upload if an image is provided
        if ($request->hasFile('image')) {
            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Create a filename using the request name and the extension
            $fileName = $request->name . '.' . $extension;
            // Store the image with the new name
            $imagePath = $request->file('image')->storeAs('images/customers/' . $branch->name, $fileName, 'public');
        }

        $customer = Customers::create([
            'branch_id' => $branch->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'medical_informations' => $request->medical_informations,
            'image' => $imagePath, // Save the image path in the database (or null if not provided)
        ]);

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Customer is Created.',
        ]);

        return redirect()->back();

    }
}
