<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    // public $table = 'user_roles';
    protected $fillable = ['title', 'id', 'description'];

    public function getRouteKeyName()
    {
        return 'title';
    }

    public function user() {
        return $this->hasMany(User::class);
    }
}
