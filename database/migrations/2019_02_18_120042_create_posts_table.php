<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    protected $table = 'posts';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->longText('description');
            $table->boolean('active')->default(Example::ACTIVE);
            $table->enum('status', Example::STATUSES)->default(Example::STATUS_1);
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
