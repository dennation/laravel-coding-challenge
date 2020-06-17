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
    public function createProperty(Request $request)
    {
        return [
            "data" => Property::create($request->all())
        ];
    }

    public function updateOrCreateAnalytics(Request $request, $propertyId){
        $property       = Property::findOrFail($propertyId);
        $analytic_type  = AnalyticType::findOrFail($request->analytic_type_id);

        $propertyAnalytics = PropertyAnalytics::firstOrNew([
            "property_id"       => $property->id,
            "analytic_type_id"  => $analytic_type->id
        ])->first();

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

    public function getPropertyAnlytics($id){
        $collection = 
            Property::with("propertyAnalytics.analyticType")
            ->find($id)
            ->propertyAnalytics;

        return ResourcesPropertyAnalytics::collection($collection);
    }

    public function getSummaryAnlytics($field, $value){
        $collection = 
            Property::with("propertyAnalytics", "propertyAnalytics.analyticType")
            ->where([$field => $value])
            ->get();

        return new SummaryAnalyticCollection($collection);
    }
}
