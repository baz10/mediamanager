<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); 
            $table->string('category_name');
            $table->timestamps();
        });

        DB::table('categories')->insert(
            [[
                'category_id' => '1',
                'category_name' => 'Movies'
            ],
            [
                'category_id' => '2',
                'category_name' => 'Music'
            ],
            [
                'category_id' => '3',
                'category_name' => 'Games'
            ]]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
