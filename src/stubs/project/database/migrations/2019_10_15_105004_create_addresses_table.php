<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('addresses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('addressable_id');
                $table->string('addressable_type');
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('gender', 1)->nullable(); //F or M
                $table->string('email')->nullable();
                $table->string('company')->nullable();
                $table->string('orgnum')->nullable();
                $table->string('phone')->nullable();
                $table->string('postcode')->nullable();
                $table->string('city')->nullable();
                $table->string('street')->nullable();
                $table->string('country')->nullable();
                $table->string('type')->default('main');
                $table->integer('ord')->default(0);
                $table->timestamps();

                $table->unique(['addressable_id', 'addressable_type', 'type']);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('addresses');
        }
    };
