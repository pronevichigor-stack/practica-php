<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'room';
    protected $primaryKey = 'room_id';
    protected $fillable = ['name', 'type', 'subdivision_id'];

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class, 'subdivision_id', 'subdivision_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'room_id', 'room_id');
    }
}