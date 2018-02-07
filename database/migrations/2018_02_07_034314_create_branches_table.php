<?PHP

use Illuminate\Database\Schema\Blueprint;
use LaravelRocket\Foundation\Database\Migration;

class CreateBranchesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		Schema::create('branches', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->string('name')->nullable();
			$table->string('country_code')->nullable();

            $table->timestamps();

			$table->index(['country_code'], 'country_code_index');

		});

		$this->updateTimestampDefaultValue('branches', ['updated_at'], ['created_at']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::dropIfExists('CreateBranchesTable');
	}
}
