<?php

namespace Bike\Api\Redis\Dao;

class AuthCodeDao extends AbstractDao
{
    protected $fields = [
        'auth_code' => null,
        'client_id' => null,
        'user_id' => null,
        'scopes' => null,
        'redirect_uri' => null,
        'expire_time' => null,
        'create_time' => null,
    ];
}
