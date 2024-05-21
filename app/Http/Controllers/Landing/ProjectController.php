<?php

namespace App\Http\Controllers\Landing;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        return $projects;
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return $project;
    }

    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "image" => 'required|mimes:jpeg,jpg,png|max:10000',
            "title" => 'required|string|max:255',
            "description" => 'required|string',
            "link" => 'required|string',
            "repo" => 'required|string',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = [
            "title" => $request->title,
            "description" => $request->description,
            "link" => $request->link,
            "repo" => $request->repo,
        ];

        if ($request->has('image')){
            $image_link = $this->uploadCloudinary($request->file('image'));
            $data["image_name"] = $request->image->getClientOriginalName();
            $data["image_url"] = $image_link;
        }

        Project::updateOrCreate([
            "id" => $id
        ], $data);

        return response()->json([
            "error" => false,
            "message" => "Data saved successfully"
        ]);
    }

    private function uploadCloudinary($file)
    {
        $path = "public/landing/project";

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $public_id = date('Y-m-d His').'_'.$fileName;

        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
            "public_id" => $public_id,
            "folder" => $path
        ])->getSecurePath();

        return $uploadedFileUrl;
    }
}
