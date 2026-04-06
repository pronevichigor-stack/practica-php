<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'subscriber';
    protected $primaryKey = 'subscriber_id';
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
        'subdivision_id',
        'created_by'
    ];

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class, 'subdivision_id', 'subdivision_id');
    }

    public function phones()
    {
        return $this->belongsToMany(Phone::class, 'subscriber_phone', 'subscriber_id', 'phone_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}