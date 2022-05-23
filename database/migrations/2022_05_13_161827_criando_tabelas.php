<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriandoTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->bigInteger('tenant_id')->nullable()->unsigned();
            $table->index('tenant_id');
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('oauth_providers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('provider');
            $table->string('provider_user_id')->index();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->string("nome");
            $table->string("nif");
            $table->timestamps();
        });
        Schema::create('tag', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->bigInteger('tenant_id')->nullable()->unsigned();
            $table->index('tenant_id');
            $table->timestamps();
        });
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("number");
            $table->bigInteger('tenant_id')->nullable()->unsigned();
            $table->index('tenant_id');
            $table->timestamps();
        });
        Schema::create('tag_in_contact', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->nullable()->unsigned();
            $table->index('tenant_id');
            $table->bigInteger('contact_id')->nullable()->unsigned();
            $table->index('contact_id');
            $table->bigInteger('tag_id')->nullable()->unsigned();
            $table->index('tag_id');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('oauth_providers');
        Schema::dropIfExists('failed_jobs');
    }
}
