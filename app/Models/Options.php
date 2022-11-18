<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'options';

    /**
     * @var array
     */
    protected $fillable = [
        'purpose', 'name', 'title', 'description', 'placeholder', 'unit', 'type', 'tooltip',
        'priority', 'status',
    ];

}
