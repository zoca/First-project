<?php

use App\Models\Example;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class AlterFormFieldsTableAddNameColumn extends Migration
{
    protected $table = 'form_fields';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('name')->after('field_type')->nullable();
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
