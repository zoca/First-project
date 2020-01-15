<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class AlterPostsTableAddOrderingColumn extends Migration
{
    protected $table = 'posts';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->integer('order_number')->after('id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
