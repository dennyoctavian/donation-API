<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use HasFactory;
    protected $table = 'pictures';

    protected $fillable = [
        'photo',
        'campaign_id',
    ];

    public function campaign()
    {
        $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
