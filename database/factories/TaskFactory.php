<?PHP

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {

    return [
        'user_id' => 0,
        'name' => $faker->name,
        'description' => null,
        'duedate' => $faker->date(),
        'status' => 0,
        'label' => 0,
    ];
});
