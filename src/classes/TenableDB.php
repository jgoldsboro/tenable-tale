<?php

class TenableDB extends SQLite3
{
    function __construct() {
        $this->open('database/tenable.db');
    }
}
