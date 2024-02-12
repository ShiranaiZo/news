<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    // use HasFactory and soft delete;
    use HasFactory, SoftDeletes;

    // protected table for prevent any changes
    protected $guarded = [
        'id', 'created_at'
    ];

    // relation belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
