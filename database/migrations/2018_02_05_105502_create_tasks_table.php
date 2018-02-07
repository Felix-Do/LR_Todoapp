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

			$table->string('name');
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
