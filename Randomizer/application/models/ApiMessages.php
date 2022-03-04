<?php

use \Illuminate\Database\Eloquent\Model as Entity;


class ApiMessages extends Entity
{
    protected $table = 'api_messages';

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'id', 'user_id', 'caller', 'response'
    ];

}