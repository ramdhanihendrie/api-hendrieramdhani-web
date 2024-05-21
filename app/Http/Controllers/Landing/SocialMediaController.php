<?php

namespace App\Http\Controllers\Landing;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
  public function index()
  {
      $socialmedias = SocialMedia::all();
      return $socialmedias;
  }

  public function show($id)
  {
      $socialmedia = SocialMedia::findOrFail($id);
      return $socialmedia;
  }

  public function store(Request $request, $id = null)
  {
      $validator = Validator::make($request->all(), [
          "name" => 'required|string|max:255',
          "link" => 'required|string',
          "icon" => 'required|string',
      ]);

      if ($validator->fails()){
          return response()->json($validator->errors());
      }

      SocialMedia::updateOrCreate([
          "id" => $id
      ], $request->all());

      return response()->json([
          "error" => false,
          "message" => "Data saved successfully"
      ]);
  }
}
