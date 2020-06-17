### Migrations & seeding
`php artisan migrate:refresh --seed`

### Run project
`php artisan serve`

### Run tests
`vendor/bin/phpunit`

### Routing for testing

###### Create new Property [POST] /api/properties
`['suburb' => 'Parramatta', 'state' => 'NSW', 'country' => 'Australia']`

###### Add/Update Property Analytic [POST] /api/properties/{property_id}/
`['analytic_type_id' => 1, 'value' => 40]`

###### Get Property Analytics [GET] /api/properties/{property_id}/

###### Get Summary Analytics by Suburb [GET] /api/summary/suburb/{suburb}/

###### Get Summary Analytics by State [GET] /api/summary/state/{state}/

###### Get Summary Analytics by Country [GET] /api/summary/country/{country}/