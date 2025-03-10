<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Override the Inertia view-finder configuration
        config()->set('inertia.testing.view-finder', resource_path('js/pages'));
    }
}
