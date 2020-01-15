<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class AlterCategoriesTableAddDeletedAtColumn extends Migration
{
    protected $table = 'categories';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->softDeletes()->after('parent_id')->nullable();
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
