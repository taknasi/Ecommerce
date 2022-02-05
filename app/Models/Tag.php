<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;
    protected $with = ['translations'];

    protected $fillable = ['slug'];
    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];
}
