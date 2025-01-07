<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase{
    public function test_example2(){
        $this->assertDatabaseCount('users', 2);
    }
}