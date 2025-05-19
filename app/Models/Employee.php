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
        'jenis_pegawai',
        'no_sip',
        'tanggal_terbit',
        'tanggal_kadaluwarsa',
        'email'
    ];
}
