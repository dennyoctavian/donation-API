<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pray extends Model
{
    use HasFactory;
    protected $table = 'prays';

    protected $fillable = [
        'user_id',
        'campaign_id',
        'pray'
    ];

    public function campaign()
    {
        $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
