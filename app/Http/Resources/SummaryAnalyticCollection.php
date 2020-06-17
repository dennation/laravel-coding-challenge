<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SummaryAnalyticCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [];

        foreach ($this->collection as $property) {
            foreach ($property->propertyAnalytics as $propertyAnalytics) {
                if (!array_key_exists($propertyAnalytics->analyticType->id, $result)) {
                    $result[$propertyAnalytics->analyticType->id] = [
                        "id"                    => $propertyAnalytics->analyticType->id,
                        "name"                  => $propertyAnalytics->analyticType->name,
                        "units"                 => $propertyAnalytics->analyticType->units,
                        "is_numeric"            => $propertyAnalytics->analyticType->is_numeric,
                        "num_decimal_places"    => $propertyAnalytics->analyticType->num_decimal_places,
                        "minValue"              => $propertyAnalytics->value,
                        "maxValue"              => $propertyAnalytics->value,
                        "medianValue"           => $propertyAnalytics->value,
                        "amount"                => $propertyAnalytics->value,
                        "count"                 => 1,
                        "properties"            => []
                    ];
                } else {
                    if ($propertyAnalytics->value > $result[$propertyAnalytics->analyticType->id]["maxValue"]) {
                        $result[$propertyAnalytics->analyticType->id]["maxValue"] = $propertyAnalytics->value;
                    }

                    if ($propertyAnalytics->value < $result[$propertyAnalytics->analyticType->id]["minValue"]) {
                        $result[$propertyAnalytics->analyticType->id]["minValue"] = $propertyAnalytics->value;
                    }

                    $result[$propertyAnalytics->analyticType->id]["amount"] += $propertyAnalytics->value;
                    $result[$propertyAnalytics->analyticType->id]["count"]++;
                }

                if (!array_key_exists($property->id, $result[$propertyAnalytics->analyticType->id]['properties'])) {
                    $result[$propertyAnalytics->analyticType->id]['properties'][$property->id] = [
                        "id"        => $property->id,
                        "guid"      => $property->guid,
                        "suburb"    => $property->suburb,
                        "state"     => $property->state,
                        "country"   => $property->country,
                        "value"     => $propertyAnalytics->value,
                    ];
                }
            }
        }

        foreach ($result as $key => $value) {
            $result[$key]["medianValue"] = $result[$key]["amount"] / $result[$key]["count"];

            foreach ($result[$key]['properties'] as $propertyKey => $property) {
                $result[$key]['properties'][$propertyKey]['percentage'] = $result[$key]['properties'][$propertyKey]['value'] / $result[$key]["amount"] * 100;
            }

            unset($result[$key]["count"]);
            unset($result[$key]["amount"]);
        }

        return [
            "data" => $result
        ];
    }
}
