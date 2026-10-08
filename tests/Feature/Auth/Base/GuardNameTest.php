<?php

namespace Tests\Feature\Auth\Base;

use App\Service\Auth\BaseAuthicate;
use Tests\TestCase;

class GuardNameTest extends TestCase
{
    use BaseAuthicate;
    /**
     * guardname
     *
     * @var string
     */
    protected $guardname = null;
    /**
     * guardNameTest
     *
     * @return string
     */
    protected function guardNameTest()
    {
        return $this->guardname;
    }
    /**
     * test_gurad_name_is_web
     *
     * @return void
     */
    public function test_gurad_name_is_web_or_admin(): void
    {
        $this->assertEquals($this->guardNameTest(), $this->getGuardName());
    }
    /**
     * test_gurad_name_null
     *
     * @return void
     */
    public function test_gurad_name_null(): void
    {
       $this->assertNull($this->getGuardName());
    }
}
