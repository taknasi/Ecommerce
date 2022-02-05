<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;
    protected $with = ['translations'];

    protected $fillable = ['is_active'];
    protected $casts = ['is_active' => 'boolean'];
    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];

    
}
