<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotaStand extends Model
{
    use HasFactory;

    protected $table = 'tbl_quota_stand';

    protected $fillable = [
        'kd_stand',
        'nama_stand',
        'quota',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i');
    }
}
