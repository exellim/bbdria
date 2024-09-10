<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $branch = Auth::user()->branches[0]->id;

        $category = Categories::with('branch','items')->where('branch_id',$branch)->get();
        return view('pages.category.index', compact('category'));
    }

    public function store(Request $request)
    {
        $branch = Auth::user()->branches[0]->id;
        Categories::create([
            'branch_id'=>$branch,
            'name'=>$request->name
        ]);

        session()->flash('toast', [
            'icon' => 'success',
            'title' => 'Operation Successful!',
            'text' => 'Category Created.',
        ]);

        return redirect()->back();
    }
}
