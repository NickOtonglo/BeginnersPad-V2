<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    public $table = 'faqs';

    protected $fillable = ['question', 'answer', 'topic'];
    
}
