<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'pangkat',
        'jabatan',
        'tanggal_lahir',
        'jenis_kelamin',
    ];
}
