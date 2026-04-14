<?php

declare(strict_types=1);

use Src\Auth\Auth;

final class BearerAuthTest extends ControllerTestCase
{
    public function testAttemptTokenReturnsUniqueToken(): void
    {
        $user = $this->createUser('autotest_api_user', 'tokenPassword123', 'employee');

        $token = Auth::attemptToken([
            'login' => 'autotest_api_user',
            'password' => 'tokenPassword123',
        ]);

        $this->assertNotNull($token);
        $this->assertSame(64, strlen($token));
        $this->assertSame($token, $user->fresh()->token);
    }

    public function testCheckSupportsBearerToken(): void
    {
        $user = $this->createUser('autotest_api_guard', 'tokenPassword123', 'admin');
        $token = $user->issueApiToken();

        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer ' . $token;
        $request = $this->makeRequest('GET');

        $this->assertTrue(Auth::check($request));
        $this->assertSame($user->id, Auth::user($request)?->id);
    }
}
