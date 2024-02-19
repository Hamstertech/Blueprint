<?php

namespace App\Interfaces;

interface DropdownModel
{
    public function getDropdownValue(): mixed;

    public function getDropdownText(): string;
}
