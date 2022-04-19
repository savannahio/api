<?php

declare(strict_types=1);

namespace Tests\Feature;

use Bus;
use Event;
use Mail;
use Notification;
use Queue;
use Tests\TestCase as BaseTestCase;

abstract class FeatureTestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Bus::fake();
        Event::fake();
        Mail::fake();
        Notification::fake();
        Queue::fake();
    }
}
