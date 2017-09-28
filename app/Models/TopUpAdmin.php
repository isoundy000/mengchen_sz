<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUpAdmin extends Model
{
    protected $table = 'top_up_admin';
    protected $primaryKey = 'id';

    protected $fillable = [
        'provider_id', 'receiver_id', 'type', 'amount', 'created_at'
    ];

    public function provider()
    {
        return $this->hasOne('App\Models\User', 'id', 'provider_id');
    }

    public function receiver()
    {
        return $this->hasOne('App\Models\User', 'id', 'receiver_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\ItemType', 'id', 'type');
    }
}