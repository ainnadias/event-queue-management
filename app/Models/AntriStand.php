<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntriStand extends Model
{
    use HasFactory;

    protected $table = 'tbl_antri_stand';

    protected $fillable = [
        'nama',
        'email',
        'tanggal_pesan',
        'kd_stand',
        'nomor_antri',
    ];

    public function stand()
    {
        return $this->belongsTo(QuotaStand::class, 'kd_stand', 'kd_stand');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i');
    }

}
