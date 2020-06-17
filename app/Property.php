<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    protected $fillable = ['suburb', 'state', 'country'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // Auto generation UUID on model creation
            $model->guid = (string) Str::uuid();
        });
    }

    /**
     * Get the Property Analytics records associated with the Property.
     */
    public function propertyAnalytics()
    {
        return $this->hasMany('App\PropertyAnalytics');
    }
}
