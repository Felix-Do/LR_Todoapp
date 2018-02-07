<?PHP

use Illuminate\Database\Schema\Blueprint;
use LaravelRocket\Foundation\Database\Migration;

class CreateBranchUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		Schema::create('branch_users', function(Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('branch_id');

            $table->timestamps();

			$table->index(['user_id'], 'fk_branch_users_users_idx');

		});

		$this->updateTimestampDefaultValue('branch_users', ['updated_at'], ['created_at']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::dropIfExists('CreateBranchUsersTable');
	}
}
