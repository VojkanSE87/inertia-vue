<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id'];

    public function clients()
    {
        return $this->hasMany(Section::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }


}
