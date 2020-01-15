<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class CreateDynamicFormsTable extends Migration
{
    protected $table = 'dynamic_forms';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_type');
            $table->string('title')->nullable();
            $table->string('seo-title')->nullable();
            $table->string('description')->nullable();
            $table->string('seo-description')->nullable();
            $table->string('state')->nullable();
            $table->string('equipment')->nullable();
            $table->string('fuel')->nullable();
            $table->string('photo')->nullable();
            $table->integer('created_by');
            $table->softDeletes();
            $table->timestamps();
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
