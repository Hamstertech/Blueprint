<?php

namespace App\Services;

class FrontendService
{
    public string $base;

    public function __construct()
    {
        $this->base = config('app.frontend_url');
    }

    public function create(string $path = '', array $query = [])
    {
        $query = count($query) ? '?'.http_build_query($query) : '';

        return $this->base.$path.$query;
    }

    public function login()
    {
        return $this->create('login');
    }
}
