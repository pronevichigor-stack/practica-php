<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'subdivision';
    protected $primaryKey = 'subdivision_id';
    protected $fillable = ['name', 'type_id'];

    // Связь с типом подразделения
    public function type()
    {
        return $this->belongsTo(TypeOfUnit::class, 'type_id', 'type_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'subdivision_id', 'subdivision_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'subdivision_id', 'subdivision_id');
    }
}