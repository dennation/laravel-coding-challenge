<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\PropertyAnalytics;
use App\AnalyticType;
use App\Http\Resources\PropertyAnalytics as ResourcesPropertyAnalytics;
use App\Http\Resources\SummaryAnalyticCollection;

class ApiController extends Controller
{ 
    /**
     * Create new Property
     *
     * @param Request $request
     * @return void
     */  
    public function createProperty(Request $request)
    {
        return [
            "data" => Property::create($request->all())
        ];
    }

    /**
     * Create or update Analytics for property by id
     *
     * @param Request $request
     * @param integer $propertyId
     * @return void
     */
    public function updateOrCreateAnalytics(Request $request, $propertyId){
        // Fail when propertyId or analyticTypeId is invalid
        $property       = Property::findOrFail($propertyId);
        $analytic_type  = AnalyticType::findOrFail($request->analytic_type_id);

        // Find or create record
        $propertyAnalytics = PropertyAnalytics::firstOrNew([
            "property_id"       => $property->id,
            "analytic_type_id"  => $analytic_type->id
        ])->first();
        
        // Save record vith new value
        try {
            $propertyAnalytics->value = $request->value;
            $propertyAnalytics->save();
            return [
                "data" => $propertyAnalytics
            ];
        } catch (\Exception $e) {
            return [
                "error" => $e->getMessage()
            ];
        }
    }

    /**
     * Returns Analytics for property by id
     *
     * @param integer $id
     * @return void
     */
    public function getPropertyAnlytics($id){
        $collection = 
            Property::with("propertyAnalytics.analyticType")
            ->find($id)
            ->propertyAnalytics;

        return ResourcesPropertyAnalytics::collection($collection);
    }

    /**
     * Returns Summary Analytics
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    public function getSummaryAnlytics($field, $value){
        $collection = 
            Property::with("propertyAnalytics", "propertyAnalytics.analyticType")
            ->where([$field => $value])
            ->get();

        return new SummaryAnalyticCollection($collection);
    }
}
