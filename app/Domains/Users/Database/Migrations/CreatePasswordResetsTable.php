<?php

namespace Confee\Domains\Users\Database\Migrations;


use Confee\Support\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResetsTable extends Migration
{

    function up()
    {
        $this->schema->create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    function down()
    {
        $this->schema->drop('password_resets');
    }
}