<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();
            $table->string('name');
            $table->string('phone', 12)->nullable();
            $table->string('fax', 12)->nullable();
            $table->string('website')->nullable();
            $table->enum('industry', [
                'Aerospace',
                'Transport',
                'Computer Hardware',
                'Telecommunicaton',
                'Agriculture',
                'Construction',
                'Education',
                'Pharmaceutical',
                'Food',
                'Healthcare',
                'Hospitality',
                'Entertainment',
                'News & Media',
                'Energy',
                'Manufacturing',
                'Music',
                'Mining',
                'Internet',
                'Electronics',
                'Engineering'
            ]);
            $table->integer('company_size')->nullable();
            $table->unsignedBigInteger('annual_revenue')->nullable();
            $table->text('description')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state', 2)->nullable();
            $table->string('billing_zip', 5)->nullable();
            $table->string('billing_country')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state', 2)->nullable();
            $table->string('shipping_zip', 5)->nullable();
            $table->string('shipping_country')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('accounts');
    }
}
