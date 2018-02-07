<?PHP

use Illuminate\Database\Schema\Blueprint;
use LaravelRocket\Foundation\Database\Migration;

class CreateTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('user_id')->default(0);
			$table->string('name')->default('');
			$table->string('description')->nullable();
			$table->date('duedate');
			$table->unsignedInteger('status')->default(0);
			$table->unsignedInteger('label')->default(0);

            $table->timestamps();


		});

		$this->updateTimestampDefaultValue('tasks', ['updated_at'], ['created_at']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::dropIfExists('CreateTasksTable');
	}
}
