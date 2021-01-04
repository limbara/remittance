<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('countries', function (Blueprint $table) {
      $table->increments('id');
      $table->string('country_name', 100);
      $table->string('country_code', 3);
      $table->string('country_flag_unicode', 30);
      $table->unsignedTinyInteger('status');
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('provinces', function (Blueprint $table) {
      $table->increments('id');
      $table->string('province_name', 100);
      $table->unsignedTinyInteger('status');
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedInteger('country_id');
      $table->foreign('country_id')->references('id')->on('countries');
    });

    Schema::create('cities', function (Blueprint $table) {
      $table->increments('id');
      $table->string('city_name', 100);
      $table->unsignedTinyInteger('status');
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedInteger('province_id');
      $table->foreign('province_id')->references('id')->on('provinces');
    });

    Schema::create('banks', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 100);
      $table->unsignedTinyInteger('status');
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedInteger('country_id');
      $table->foreign('country_id')->references('id')->on('countries');
    });

    Schema::create('currencies', function (Blueprint $table) {
      $table->string('currency_code', 3);
      $table->string('currency_name', 40);
      $table->string('currency_symbol_unicode', 30);
      $table->unsignedTinyInteger('minor_unit');
      $table->unsignedInteger('transaction_fee');
      $table->unsignedInteger('transaction_minimum_amount');
      $table->unsignedInteger('transaction_maximum_amount');
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedInteger('country_id');
      $table->foreign('country_id')->references('id')->on('countries');
      $table->primary('currency_code');
    });

    Schema::create('exchange_rates', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('currency_from', 3);
      $table->string('currency_to', 3);
      $table->decimal('conversion_rate', 11, 6);
      $table->timestamps();
    });

    Schema::create('payment_methods', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 40);
      $table->timestamps();
    });

    Schema::create('country_has_payment_methods', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedTinyInteger('status');
      $table->timestamps();
      $table->unsignedInteger('payment_method_id');
      $table->unsignedInteger('country_id');
      $table->foreign('payment_method_id')->references('id')->on('payment_methods');
      $table->foreign('country_id')->references('id')->on('countries');
    });

    Schema::create('voucher_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id');
      $table->string('description');
      $table->timestamps();
      $table->primary('id');
    });

    Schema::create('vouchers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('point_cost');
      $table->timestamp('valid_from');
      $table->timestamp('valid_to');
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedTinyInteger('voucher_type_id');
      $table->foreign('voucher_type_id')->references('id')->on('voucher_types');
    });

    Schema::create('voucher_values', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('amount');
      $table->string('currency_code', 3);
      $table->timestamps();
      $table->unsignedBigInteger('voucher_id');
      $table->foreign('voucher_id')->references('id')->on('vouchers');
    });

    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('phone_number', 20);
      $table->string('email')->unique();
      $table->integer('point')->default(0);
      $table->timestamps();
    });

    Schema::create('user_profiles', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('first_name', 100);
      $table->string('last_name', 100);
      $table->date('birth_date');
      $table->string('legal_identifier', 100);
      $table->text('address');
      $table->tinyInteger('gender');
      $table->text('photo');
      $table->tinyInteger('verified')->default(0);
      $table->timestamps();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedInteger('city_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('city_id')->references('id')->on('cities');
    });

    Schema::create('user_has_vouchers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('voucher_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('voucher_id')->references('id')->on('vouchers');
    });

    Schema::create('user_point_histories', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('description', 300);
      $table->tinyInteger('type');
      $table->integer('amount');
      $table->timestamp('created_at');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
    });

    Schema::create('relationships', function (Blueprint $table) {
      $table->unsignedTinyInteger('id');
      $table->primary('id');
      $table->string('description', 100);
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('recipients', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('first_name', 100);
      $table->string('last_name', 100);
      $table->string('email')->nullable();
      $table->string('account_number', 100);
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedInteger('bank_id');
      $table->unsignedBigInteger('user_id');
      $table->unsignedTinyInteger('relationship_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('bank_id')->references('id')->on('banks');
      $table->foreign('relationship_id')->references('id')->on('relationships');
    });

    Schema::create('transaction_requirements', function (Blueprint $table) {
      $table->string('key', 255);
      $table->string('description');
      $table->timestamps();
      $table->primary('key');
    });

    Schema::create('country_has_transaction_requirements', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->unsignedInteger('country_id');
      $table->string('transaction_requirement_key');
      $table->foreign('country_id')->references('id')->on('countries');
      $table->foreign('transaction_requirement_key', 'country_has_transaction_req_requirement_key_foreign')->references('key')->on('transaction_requirements');
    });

    Schema::create('transactions', function (Blueprint $table) {
      $table->uuid('id');
      $table->primary('id');
      $table->string('currency_from', 3);
      $table->string('currency_to', 3);
      $table->decimal('conversion_rate', 11, 6);
      $table->unsignedBigInteger('total_amount');
      $table->unsignedBigInteger('transfer_amount');
      $table->unsignedBigInteger('amount');
      $table->unsignedInteger('point');
      $table->unsignedInteger('fee');
      $table->unsignedInteger('discount');
      $table->json('requirements');
      $table->timestamp('expired_at');
      $table->timestamp('created_at');
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('voucher_id')->nullable();
      $table->unsignedBigInteger('recipient_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('voucher_id')->references('id')->on('vouchers');
      $table->foreign('recipient_id')->references('id')->on('recipients');
    });

    Schema::create('transaction_statuses', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedTinyInteger('status');
      $table->timestamp('created_at');
      $table->uuid('transaction_id');
      $table->foreign('transaction_id')->references('id')->on('transactions');
    });

    Schema::create('payments', function (Blueprint $table) {
      $table->uuid('id');
      $table->primary('id');
      $table->timestamp('created_at');
      $table->uuid('transaction_id');
      $table->unsignedInteger('payment_method_id');
      $table->foreign('transaction_id')->references('id')->on('transactions');
      $table->foreign('payment_method_id')->references('id')->on('payment_methods');
    });

    Schema::create('payment_statuses', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedTinyInteger('status');
      $table->timestamp('created_at');
      $table->uuid('payment_id');
      $table->foreign('payment_id')->references('id')->on('payments');
    });

    Schema::create('notification_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id');
      $table->primary('id');
      $table->string('name', 100);
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('notifications', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title');
      $table->text('body');
      $table->timestamp('read_at')->nullable();
      $table->timestamps();
      $table->softDeletes();
      $table->unsignedTinyInteger('notification_type_id');
      $table->unsignedBigInteger('user_id');
      $table->foreign('notification_type_id')->references('id')->on('notification_types');
      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('transaction_statuses');
    Schema::dropIfExists('payment_statuses');
    Schema::dropIfExists('payments');
    Schema::dropIfExists('country_has_transaction_requirements');
    Schema::dropIfExists('transaction_requirements');
    Schema::dropIfExists('transactions');
    Schema::dropIfExists('user_profiles');
    Schema::dropIfExists('recipients');
    Schema::dropIfExists('country_has_payment_methods');
    Schema::dropIfExists('cities');
    Schema::dropIfExists('provinces');
    Schema::dropIfExists('banks');
    Schema::dropIfExists('currencies');
    Schema::dropIfExists('countries');
    Schema::dropIfExists('exchange_rates');
    Schema::dropIfExists('payment_methods');
    Schema::dropIfExists('user_has_vouchers');
    Schema::dropIfExists('voucher_values');
    Schema::dropIfExists('vouchers');
    Schema::dropIfExists('voucher_types');
    Schema::dropIfExists('user_point_histories');
    Schema::dropIfExists('relationships');
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('notification_types');
    Schema::dropIfExists('users');
  }
}
