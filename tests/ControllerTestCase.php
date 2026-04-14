<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Model\Role;
use Model\User;
use PHPUnit\Framework\TestCase;
use Src\Auth\Auth;
use Src\Request;
use Src\Settings;

abstract class ControllerTestCase extends TestCase
{
    protected TestRoute $route;

    protected function setUp(): void
    {
        parent::setUp();

        $_SESSION = [];
        $_REQUEST = [];
        $_FILES = [];
        unset($_SERVER['HTTP_AUTHORIZATION']);
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../public');
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->bootDatabase();
        $this->bootApp();
        $this->ensureRole('admin');
        $this->ensureRole('employee');
        Auth::init(new User());
    }

    protected function tearDown(): void
    {
        if (Capsule::schema()->hasColumn('users', 'token')) {
            Capsule::table('users')->where('login', 'like', 'autotest_%')->update(['token' => null]);
        }

        User::where('login', 'like', 'autotest_%')->delete();
        $_SESSION = [];

        parent::tearDown();
    }

    protected function makeRequest(string $method, array $data = []): Request
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_REQUEST = $data;

        return new Request();
    }

    protected function createUser(string $login, string $password, string $roleName): User
    {
        User::where('login', $login)->delete();

        $id = Capsule::table('users')->insertGetId([
            'login' => $login,
            'password' => md5($password),
            'role_id' => $this->ensureRole($roleName)->id,
        ]);

        return User::find($id);
    }

    protected function loginAs(string $login, string $password, string $roleName = 'admin'): User
    {
        $user = $this->createUser($login, $password, $roleName)->fresh();
        Auth::login($user);

        return $user;
    }

    protected function runAction(callable $callback): array
    {
        ob_start();
        $result = $callback();
        $output = ob_get_clean();

        return [$result, $output];
    }

    protected function ensureRole(string $name): Role
    {
        return Role::firstOrCreate(['name' => $name]);
    }

    private function bootApp(): void
    {
        $settings = new Settings([
            'app' => include __DIR__ . '/../config/app.php',
            'db' => include __DIR__ . '/../config/db.php',
            'path' => include __DIR__ . '/../config/path.php',
        ]);

        $this->route = new TestRoute();
        $GLOBALS['app'] = new TestApp($settings, $this->route);
    }

    private function bootDatabase(): void
    {
        $capsule = new Capsule();
        $capsule->addConnection(include __DIR__ . '/../config/db.php');
        $capsule->setEventDispatcher(new Dispatcher(new Container()));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
