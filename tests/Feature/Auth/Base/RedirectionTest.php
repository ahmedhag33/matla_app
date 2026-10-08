<?php

namespace Tests\Feature\Auth\Base;

use App\Service\Auth\BaseAuthicate;
use Tests\TestCase;

class RedirectionTest extends TestCase
{
    use BaseAuthicate;
    /**
     * test_redirection_page_is_not_null
     *
     * @return void
     */
    public function test_redirection_page_is_found(): void
    {
      $this->assertEquals('index-page', $this->getRedirection());
    }
}
