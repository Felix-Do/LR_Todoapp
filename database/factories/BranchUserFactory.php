<?PHP

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BranchUser::class, function (Faker\Generator $faker) {

    return [
        'user_id' => 0,
        'branch_id' => 0,
    ];
});
