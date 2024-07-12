<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];
    public $timestamps = false;
    public $table = 'system';

    public function getRouteKeyName()
    {
        return 'key';
    }
}
