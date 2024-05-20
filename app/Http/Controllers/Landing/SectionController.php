<?php

namespace App\Http\Controllers\Landing;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return $sections;
    }

    public function show($id)
    {
        $section = Section::findOrFail($id);
        return $section;
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required|string|max:255',
            "description" => 'string',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        Section::updateOrCreate([
            "id" => $id
        ], $request->all());
    }
}
