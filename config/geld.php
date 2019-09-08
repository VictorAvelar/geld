<?php

return [
    /*
     * A unique key assigned to each Fixer.io API account used to authenticate with the API.
     *
     * Get a free API key at https://fixer.io
     */
    'access_key' => env("FIXER_API_KEY", ""),

    /*
     * The scheduler will automatically update the exchange rates by calling the api endpoint and it will perform the
     * required actions to keep everything up to date.
     */
    'auto_schedule' => true,

    /*
     * Base is the main currency of your website, it defaults to EUR but you can set it up to any currency available
     * on fixer.io
     */
    'base' => 'EUR',

    /*
     * Supported is an array of the currencies supported by your laravel site if an operation with a non supported
     * currency is intended the the package will throw an exception.
     */
    'supported' => ['USD'],

    /*
     * Storage mode tells the package how to remember currencies when an update happens, it can be set to latest or
     * history.
     * Latest means that the package will override the currency value on every update.
     * History means that an extra table called currency history will be created and the package will save the old
     * records there.
     *
     * It defaults to latest.
     */
    'storage_mode' => 'latest',

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
