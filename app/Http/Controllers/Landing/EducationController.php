<?php

namespace App\Http\Controllers\Landing;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::get();
        return $educations;
    }

    public function show($id)
    {
        $education = Education::findOrFail($id);
        return $education;
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "school" => 'required|string|max:255',
            "description" => 'string',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        Education::updateOrCreate([
            "id" => $id
        ], $request->all());

        return response()->json([
            "error" => false,
            "message" => "Data saved successfully"
        ]);
    }
}
