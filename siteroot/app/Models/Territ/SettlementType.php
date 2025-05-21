<?php

namespace App\Models\Territory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettlementType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'short_name'];

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}
