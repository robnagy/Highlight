<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dateTime('display_date')->after('status')->default(DB::raw('NOW()'));
            if (Schema::hasColumn('tasks', 'subTasks')) {
                $table->dropColumn(['subTasks']);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tasks', 'display_date')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn(['display_date']);
            });
        }
    }
}
