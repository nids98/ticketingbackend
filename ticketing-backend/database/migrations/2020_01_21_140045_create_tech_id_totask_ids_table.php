<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechIdTotaskIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_id_totask_ids', function (Blueprint $table) {
            $table->bigIncrements('task_id');
            $table->UnsignedBigInteger('tech_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('tech_id')->references('tech_id')
                ->on('technicians')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tech_id_totask_ids');
    }
}
