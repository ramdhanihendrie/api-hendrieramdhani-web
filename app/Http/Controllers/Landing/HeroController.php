<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::first();
        return $hero;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "greeting" => 'string|max:255',
            "fullname" => 'string|max:255',
            "position" => 'string|max:255',
            "image" => 'mimes:jpeg,jpg,png|max:10000',
            "file" => 'mimes:pdf|max:10000'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = [
            "greeting" => $request->greeting,
            "fullname" => $request->fullname,
            "position" => $request->position,
        ];

        if ($request->has('image')){
            $image_link = $this->uploadCloudinary($request->file('image'));
            $data["image_name"] = $request->image->getClientOriginalName();
            $data["image_url"] = $image_link;
        }

        if ($request->has('file')){
            $file_link = $this->uploadCloudinary($request->file('file'));
            $data["file_name"] = $request->file->getClientOriginalName();
            $data["file_url"] = $file_link;
        }

        Hero::updateOrCreate([
            "id" => 1
        ], $data);

        return response()->json([
            "error" => false,
            "message" => "Data saved successfully"
        ]);
    }

    private function uploadCloudinary($file)
    {
        $path = "public/landing";

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $public_id = date('Y-m-d His').'_'.$fileName;

        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
            "public_id" => $public_id,
            "folder" => $path
        ])->getSecurePath();

        return $uploadedFileUrl;
    }
}
