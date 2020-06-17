<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAnalytics extends Model
{
    protected $fillable = ['property_id', 'value'];

    /**
     * Get the Property record associated with the Property Analytics.
     */
    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    /**
     * Get the Analytic Type record associated with the Property Analytics.
     */
    public function analyticType()
    {
        return $this->belongsTo('App\AnalyticType');
    }
}
