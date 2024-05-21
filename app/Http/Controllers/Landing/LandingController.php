<?php

namespace App\Http\Controllers\Landing;

use App\Models\Hero;
use App\Models\Project;
use App\Models\Section;
use App\Models\Education;
use App\Models\TechStack;
use App\Models\Certificate;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        $hero = Hero::first();
        $educations = Education::all();
        $certificates = Certificate::all();
        $projects = Project::all();
        $techstack = TechStack::all();
        $sections = Section::all();
        $socialmedia = SocialMedia::all();

        return response()->json([
            "error" => false,
            "data" => [
                "hero" => $hero,
                "about" => [
                    "title" => $sections[0]->title,
                    "description" => $sections[0]->description,
                    "techList" => $techstack,
                ],
                "education" => [
                    "title" => $sections[1]->title,
                    "description" => $sections[1]->description,
                    "educationList" => $educations,
                ],
                "certificate" => [
                    "title" => $sections[2]->title,
                    "description" => $sections[2]->description,
                    "certificateList" => $certificates,
                ],
                "project" => [
                    "title" => $sections[3]->title,
                    "description" => $sections[3]->description,
                    "projectList" => $projects,
                ],
                "contact" => [
                    "title" => $sections[4]->title,
                    "description" => $sections[4]->description,
                    "socialMedia" => $socialmedia,
                ],
            ]
        ]);
    }
}
