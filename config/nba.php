<?php

return [
    /*
    |--------------------------------------------------------------------------
    | NBA Content API 2.0 Access Token
    |--------------------------------------------------------------------------
    |
    | Access token for version 2.0 of the NBA's Content API
    |
    */
    'capi_token' => env('CONTENT_API_ACCESS_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | NBA Season Year for Stat Feeds
    |--------------------------------------------------------------------------
    |
    | Season year to use for stat feeds by default (MAYBE REMOVE AFTER SEED?)
    |
    */
    'season_year' => env('STATS_SEASON_YEAR', \Carbon\Carbon::now()->year),
];
