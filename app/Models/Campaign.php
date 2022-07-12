<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'target_funds',
        'total_donation',
        'description',
        'status',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'campaign_id');
    }

    public function prays()
    {
        return $this->hasMany(Pray::class, 'campaign_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'campaign_id');
    }
}
