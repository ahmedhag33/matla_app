<?php

namespace Tests\Feature\Auth\Base;

use App\Service\Auth\BaseAuthicate;
use Illuminate\Contracts\Auth\Guard;
use Tests\TestCase;

class GuardTest extends TestCase
{
    use BaseAuthicate;
    /**
     * test guard is found
     *
     * @return void
     */
    public function test_guard_is_found(): void
    {
       $this->assertInstanceOf(Guard::class, $this->guard());
    }
    /**
     * test employee guard is defined
     *
     * @return void
     */
    public function test_employee_guard_is_defined()
    {
        $this->assertArrayHasKey('admin', config('auth.guards'));
    }
    /**
     * test employee guard is found
     *
     * @return void
     */
    public function test_employee_guard_is_found()
    {
        $this->assertInstanceOf(Guard::class,auth()->guard('admin'));
    }
}
