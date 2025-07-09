<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('barber') && !Schema::hasTable('barbers')) {
            Schema::rename('barber', 'barbers');
        }


        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['barber_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['service_id']);

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict');
            $table->foreign('barber_id')->references('id')->on('barbers')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
        });

        Schema::table('barbers', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('restrict');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['barber_id']);

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('barber_id')->references('id')->on('barbers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('barbers') && !Schema::hasTable('barber')) {
            Schema::rename('barbers', 'barber');
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['barber_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['service_id']);

            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('barber_id')->references('id')->on('barber');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('service_id')->references('id')->on('services');
        });

        Schema::table('barber', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->foreign('booking_id')->references('id')->on('bookings');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['barber_id']);

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('barber_id')->references('id')->on('barber');
        });
    }
};
