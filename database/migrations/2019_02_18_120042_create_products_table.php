<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    protected $table = 'products';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('primary_category_id');
            $table->string('name', 100);
            $table->double('price', 15,2);
            $table->string('sku')->unique();
            $table->longText('description')->nullable();
            $table->boolean('active')->default(Example::ACTIVE);
            $table->softDeletes();
            $table->integer('created_by');
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
