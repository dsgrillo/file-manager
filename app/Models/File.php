<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name', 'extension', 'size', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
