<?php

declare(strict_types=1);

use Controller\Site;
use Src\Request;

final class SiteTest extends ControllerTestCase
{
    public function testLoginPageIsShownForGetRequest(): void
    {
        [$result, $output] = $this->runAction(
            fn () => (new Site())->login($this->makeRequest('GET'))
        );

        $this->assertSame('1', $result);
        $this->assertStringContainsString('<form method="post"', $output);
        $this->assertStringContainsString('name="login"', $output);
        $this->assertStringContainsString('name="password"', $output);
    }

    public function testLoginShowsErrorForInvalidCredentials(): void
    {
        $request = $this->makeRequest('POST', [
            'login' => 'autotest_missing_user',
            'password' => 'wrong-password',
        ]);

        [$result, $output] = $this->runAction(
            fn () => (new Site())->login($request)
        );

        $this->assertSame('1', $result);
        $this->assertStringContainsString('Неправильные логин или пароль', $output);
        $this->assertStringContainsString('autotest_missing_user', $output);
    }

    public function testLoginRedirectsToDashboardForValidCredentials(): void
    {
        $user = $this->createUser('autotest_login_user', 'validPassword123', 'admin')->fresh();
        $request = $this->makeRequest('POST', [
            'login' => 'autotest_login_user',
            'password' => 'validPassword123',
        ]);

        [$result, $output] = $this->runAction(
            fn () => (new Site())->login($request)
        );

        $this->assertSame('', $result);
        $this->assertSame('', $output);
        $this->assertSame('/dashboard', $this->route->redirectUrl);
        $this->assertSame($user->id, $_SESSION['id'] ?? null);
    }
}
