<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'description',
        'deadline',
        'status'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
