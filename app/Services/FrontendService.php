<?php

namespace App\Services;

class FrontendService
{
    public string $base;

    public function __construct()
    {
        $this->base = config('app.frontend_url');
    }

    public function create(string $path = '')
    {
        return $this->base.$path;
    }

    public function login()
    {
        return $this->create('login');
    }
}
