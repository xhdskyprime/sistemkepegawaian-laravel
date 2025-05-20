<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulerSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'day_of_week',
        'hour',
        'minute',
    ];
}
