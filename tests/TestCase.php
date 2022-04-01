<?php

namespace EscolaLms\Cmi5\Tests;

use EscolaLms\Auth\Models\User;
use EscolaLms\Cmi5\EscolaLmsCmi5ServiceProvider;
use EscolaLms\Core\Tests\TestCase as CoreTestCase;
use Laravel\Passport\PassportServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends CoreTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            PassportServiceProvider::class,
            PermissionServiceProvider::class,
            EscolaLmsCmi5ServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('passport.client_uuids', true);
    }
}
