<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class MyTestCase extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public User $otherUser;


    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser=User::factory()->create();
    }
}
