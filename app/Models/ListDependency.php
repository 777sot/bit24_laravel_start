<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDependency extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function field()
    {
        return $this->belongsTo(Field::class,'field_id','id');
    }

    public function list_field()
    {
        return $this->belongsTo(ListField::class,'list_field_id','id');
    }
}
