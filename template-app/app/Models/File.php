<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'user_id',
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    public function link()
    {
        $user_id = $this->user_id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = $this->filename;
        return $user_folder . $filename;
    }
}
