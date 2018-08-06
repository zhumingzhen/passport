<?php
/**
 * Created by PhpStorm.
 * User: zhumingzhen
 * Email: z@it.me
 * Date: 2018/5/31
 * Time: 18:29
 */

return [
    'proxy' => [
        'grant_type'    => env('OAUTH_GRANT_TYPE'),
        'client_id'     => env('OAUTH_CLIENT_ID'),
        'client_secret' => env('OAUTH_CLIENT_SECRET'),
        'scope'         => env('OAUTH_SCOPE', '*'),
    ],
];