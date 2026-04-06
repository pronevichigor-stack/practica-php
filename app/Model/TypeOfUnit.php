<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfUnit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'type_of_unit';
    protected $primaryKey = 'type_id';
    protected $fillable = ['name'];
}