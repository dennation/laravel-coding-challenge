<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyticType extends Model
{
    protected $fillable = ['name', 'units', 'is_numeric', 'num_decimal_places'];

    /**
     * Get the Property Analytics records associated with the Analytic Type.
     */
    public function propertyAnalytics()
    {
        return $this->belongsToMany('App\PropertyAnalytics');
    }
}
