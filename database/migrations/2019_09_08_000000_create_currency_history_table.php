<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCurrenciesTable
 *
 * @author Victor Avelar <deltatuts@gmail.com>
 */
class CreateCurrencyHistoryTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Schema::create('currency_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 3)
                ->comment('Currency code in ISO 4217 format');
            $table->float('rate', 10, 5)
                ->comment('the exchange rate');
            $table->timestamp('imported_at')
                ->useCurrent()
                ->comment('Timestamp returned by the API');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        Schema::dropIfExists('currency_history');
    }
}
