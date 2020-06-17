<?php

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;


use App\Property;
use App\AnalyticType;
use App\PropertyAnalytics;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        // Load dataset file
        $spreadsheet = IOFactory::load('./database/dataset.xlsx');

        // Seeding Properties table with saving id's transition
        $spreadsheet->setActiveSheetIndexByName('Properties');
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $properiesIdTransition = [];

        for ($i=1; $i < count($rows); $i++) { 
            $property = Property::create([
                "suburb"    => $rows[$i][1],
                "state"     => $rows[$i][2],
                "country"   => $rows[$i][3]
            ]);
            $properiesIdTransition[$rows[$i][0]] = $property->id;
        }

        // Seeding Analytic Types table with saving id's transition
        $spreadsheet->setActiveSheetIndexByName('AnalyticTypes');
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $analyticTypesIdTransition = [];

        for ($i=1; $i < count($rows); $i++) { 
            $property = AnalyticType::create([
                "name"                  => $rows[$i][1],
                "units"                 => $rows[$i][2],
                "is_numeric"            => $rows[$i][3],
                "num_decimal_places"    => $rows[$i][4]
            ]);
            $analyticTypesIdTransition[$rows[$i][0]] = $property->id;
        }

        // Seeding Property Analytics table uses altered ids
        $spreadsheet->setActiveSheetIndexByName('Property_analytics');
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        for ($i=1; $i < count($rows); $i++) { 
            $property = PropertyAnalytics::create([
                "property_id"           => $properiesIdTransition[$rows[$i][0]],
                "analytic_type_id"      => $analyticTypesIdTransition[$rows[$i][1]],
                "value"                 => $rows[$i][2],
            ]);
        }
    }
}
