<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestFolioLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_folio_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('guestfolio_id')->unsigned();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->string('type');

            // Contacts
            $table->integer('guest_id')->unsigned()->nullable();

            // Note Logs
            $table->string('note_title')->nullable();
            $table->text('note_body')->nullable();

            // CRM/Rewards
            

            // Reservations
            

            // Audit Trail
            
            
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
        Schema::dropIfExists('guest_folio_logs');
    }
}
