<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'phone';
    protected $primaryKey = 'phone_id';
    protected $fillable = ['phone_number', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_phone', 'phone_id', 'subscriber_id');
    }
}