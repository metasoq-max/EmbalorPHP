<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class HomeController
{
    public function __construct(private Database $db, private Auth $auth)
    {
    }

    public function index(): void
    {
        view('home/index', ['user' => $this->auth->user()]);
    }
}
