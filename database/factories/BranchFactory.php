<?PHP

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Branch::class, function (Faker\Generator $faker) {

    return [
        'name' => null,
        'country_code' => null,
    ];
});
