<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadableForm extends Model
{
    protected $fillable = ['label', 'file_path'];
}