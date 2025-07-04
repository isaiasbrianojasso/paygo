<?php

namespace App\Services;

class AutoremoveService
{
    public $username;
    public $password;
    protected $isHtml;

    public function __construct($username, $password, $isHtml = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->isHtml = $isHtml;
    }

}
