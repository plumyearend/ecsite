<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * アプリケーションのベースURLを取得
     */
    public function getBaseUrl()
    {
        return 'http://localhost';
    }
}
