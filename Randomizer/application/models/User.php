<?php

use \Illuminate\Database\Eloquent\Model as Entity;

class User extends Entity
{
    protected $table = 'users';

    public string $userId;
    public string $userName;
    public string $userPassword;

    protected $primaryKey = 'user_id';
    public $incrementing = false;


    protected $fillable = [
        'user_name', 'user_id', 'user_password'
    ];

}