<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->index();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('office_phone', 12)->nullable();
            $table->string('mobile', 12)->nullable();
            $table->string('fax', 12)->nullable();
            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->string('report_to')->nullable();
            $table->string('department')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('other_phone')->nullable();
            $table->string('assistant_name')->nullable();
            $table->string('assistant_phone', 12)->nullable();
            $table->text('description')->nullable();
            $table->enum('lead_source', [
                'Website',
                'Advertisement',
                'Google',
                'Facebook',
                'Instagram',
                'Youtube',
                'LinkedIn',
                'Phone',
                'Referral',
            ]);
            $table->enum('lead_status', [
                'Cold',
                'Warm',
                'Hot'
            ]);
            $table->string('mailing_address')->nullable();
            $table->string('mailing_city')->nullable();
            $table->string('mailing_state', 2)->nullable();
            $table->string('mailing_zip', 5)->nullable();
            $table->string('mailing_country')->nullable();
            $table->timestamp('in_touch_request_date')->nullable();
            $table->timestamp('in_touch_save_date')->nullable();
            $table->timestamp('birthdate')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
