<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image_name',
        'image_url',
        'title',
        'description',
        'link',
        'repo',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
