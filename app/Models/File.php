<?php


namespace App\Models;

use App\Helpers\Formatter;
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

    public function getSizeUnitAttribute()
    {
        return Formatter::bytesToHuman($this->size);
    }
}
