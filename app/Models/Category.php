<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    protected $with = ['translations'];

    protected $fillable = ['slug', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    protected $translatedAttributes = ['name'];

    // protected $hidden = ['translations'];

    public function scopeParente($query)
    {
        return $query->whereNull('parent_id');
    }

    public function parentt()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function isActive($bol)
    {
        return $bol == true ? 'مفعل'  : 'غير مفعل';
    }
}
