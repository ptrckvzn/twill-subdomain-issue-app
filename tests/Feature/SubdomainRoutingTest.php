<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubdomainRoutingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_logged_in_admin_can_access_admin()
    {
        $this->asAdmin();

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_users_page_access()
    {
        $this->asPublisher();

        $response = $this->get('/admin/users');

        $response->assertStatus(403);

        $this->asSuperAdmin();

        /**
         * Running a second get whithin the same test triggers the error.
         *
         * Next Illuminate\View\ViewException: foreach() argument must be of type array|object, string given (View: /var/www/html/vendor/area17/twill/views/partials/navigation/_overlay_navigation.blade.php)
         *
         * If dumping the content of `config('twill-navigation')`, I get 'pages' string, as the SupportSubdomainRouting.php seems to take another level off the navigation with the key() statement.
         */
        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }
}
