<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Translatable;
    protected $with = ['translations'];

    protected $fillable = ['price','product_id','attribute_id'];

    protected $translatedAttributes = ['name'];
    protected $hidden = ['translations'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class)->withDefault();
    }
}
