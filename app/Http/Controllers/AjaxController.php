<?php

namespace App\Http\Controllers;

use App\Models\Treatments;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    public function getTreatmentPrice(Request $request)
    {
    $treatmentId = $request->input('treatment_id');
    $treatment = Treatments::find($treatmentId);

    if ($treatment) {
        return response()->json(['price' => $treatment->price]);
    }

    return response()->json(['error' => 'Treatment not found'], 404);
    }
}
