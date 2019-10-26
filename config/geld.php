<?php

return [
    /*
     * A unique key assigned to each Fixer.io API account used to authenticate with the API.
     *
     * Get a free API key at https://fixer.io
     */
    'access_key' => env("FIXER_API_KEY", ""),

    /*
     * Base is the main currency of your website, it defaults to EUR but you can set it up to any currency available
     * on fixer.io if you have a PREMIUM account.
     */
    'base' => 'EUR',

    /*
     * Supported is an array of the currencies supported by your laravel site, only supported currencies are
     * persisted to your database.
     */
    'supported' => ['USD'],

    /*
     * History mode tells the package to remember currencies when an update happens.
     *
     * When set to false the package will override the currency value on every update.
     * When set to true the package will save the old records in the currency_history table.
     *
     * It defaults to true.
     */
    'history_mode' => true,

    /*
     * Retention will only be considered when the storage mode is set to history, it tells the package for how long
     * it needs to keep the history records, this value defaults to 1 week and it should be defined with a string
     * valid for the php strtotime function.
     *
     * Once the record exceeds the retention period it will be soft deleted.
     */
    'retention' => '7 days',

    /*
     * This value enables a feature to hard delete the history records from the database, this will help you control
     * the size of your currency_history database table.
     */
    'incinerate' => true,

    /*
     * Incinerate after will only be considered when the storage mode is set to history, it tells the package when
     * it needs to hard delete the currency history records, this value defaults to 3 months and it should be defined
     * with a string valid for the php strtotime function.
     *
     * Once the record exceeds the incinerate after period it will be hard deleted.
     */
    'incinerate_after' => '3 months',
];
