<?php

namespace App\Http\Controllers\Landing;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::get();
        return $certificates;
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return $certificate;
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "image" => 'mimes:jpeg,jpg,png|max:10000',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = [
            "name" => $request->name
        ];

        if ($request->has('image')){
            $image_link = $this->uploadCloudinary($request->file('image'));
            $data["image_name"] = $request->image->getClientOriginalName();
            $data["image_url"] = $image_link;
        }

        Certificate::updateOrCreate([
            "id" => $id
        ], $data);

        return response()->json([
            "error" => false,
            "message" => "Data saved successfully"
        ]);
    }

    private function uploadCloudinary($file)
    {
        $path = "public/landing/certificate";

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $public_id = date('Y-m-d His').'_'.$fileName;

        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
            "public_id" => $public_id,
            "folder" => $path
        ])->getSecurePath();

        return $uploadedFileUrl;
    }
}
