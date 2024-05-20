<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'greeting',
        'fullname',
        'position',
        'image_name',
        'image_url',
        'file_name',
        'file_url'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
