<?php

namespace Tests\Feature\Auth\Base;

use App\Service\Auth\BaseAuthicate;
use Tests\TestCase;

class UsernameTest extends TestCase
{
    use BaseAuthicate;
    /**
     * usernameTest
     *
     * @return string
     */
    private function usernameTest(): string
    {
        return $this->getUsername();
    }
    /**
     * test_username_is_phone
     *
     * @return void
     */
    public function test_username_is_phone(): void
    {
        $this->assertEquals('phone', $this->usernameTest());
    }
    /**
     * test_username__not_null
     *
     * @return void
     */
    public function test_username__not_null(): void
    {
        $this->assertNotNull($this->getUsername());
    }
}
