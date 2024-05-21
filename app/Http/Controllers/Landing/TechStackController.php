<?php

namespace App\Http\Controllers\Landing;

use App\Models\TechStack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TechStackController extends Controller
{
    public function index()
    {
        $techstacks = TechStack::all();
        return $techstacks;
    }

    public function show($id)
    {
        $techstack = TechStack::findOrFail($id);
        return $techstack;
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "icon" => 'required|string',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        TechStack::updateOrCreate([
            "id" => $id
        ], $request->all());

        return response()->json([
            "error" => false,
            "message" => "Data saved successfully"
        ]);
    }
}
