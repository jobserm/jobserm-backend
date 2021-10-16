<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('compensation', 8, 2);
            $table->mediumText("description");
            $table->mediumText('requirement');
            $table->text('province');
            $table->string('title');
            $table->integer('report')->default(0);
            $table->enum('working_status', ['AVAILABLE', 'IN PROGRESS', 'FINISH'])->default('AVAILABLE');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
