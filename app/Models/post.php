<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\comment;



class post extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'user_id',
        'image_path',
        'post_caption'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(comment::class);
    }
}
