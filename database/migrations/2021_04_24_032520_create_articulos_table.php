<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string("codigo",10);
            $table->string("descripcion",50);
            $table->integer("cantidad");
            $table->decimal("precio",8,2);
            $table->timestamps();
        });
        Schema::create('bo_participants', function (Blueprint $table) {
            $table->id();
            $table->string("code",20);
            $table->string("globalid",50);
            $table->string("status",20);
            $table->string("name",200);
            $table->date("birthday");
            $table->string("agegroup",20);
            $table->string("tutor",200);
            $table->string("program_type",100);
            $table->string("funding_type",100);
            $table->timestamps();
        });
        Schema::create('bo_ev_when', function (Blueprint $table) {
            $table->id();
            $table->string("year",20);
            $table->string("name",50);
            $table->string("fcp",20);
            $table->integer("userid");
            $table->timestamps();
        });
        Schema::create('bo_ev_assesments', function (Blueprint $table) {
            $table->id();
            $table->foreign('when_id')->references('id')->on('bo_ev_when')->onDelete('cascade');
            $table->foreign('global_id')->references('global_id')->on('bo_participants')->onDelete('cascade');
            $table->foreign('code')->references('code')->on('bo_participants')->onDelete('cascade');

            $table->string("assesment",200);
            $table->string("tutor",200);
            $table->integer("userid");
            $table->timestamps();
        });
        Schema::create('bo_ev_indicators', function (Blueprint $table) {
            $table->id();
            $table->string("year",20);
            $table->string("agegroup",50);
            $table->text("outcome");
            $table->text("milestone");
            $table->string("mpcode",50);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
