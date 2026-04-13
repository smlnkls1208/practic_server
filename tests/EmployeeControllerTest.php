<?php

declare(strict_types=1);

use Controller\EmployeeController;
use Model\User;

final class EmployeeControllerTest extends ControllerTestCase
{
    public function testCreateShowsErrorsForEmptyFields(): void
    {
        $this->loginAs('autotest_admin_empty', 'adminPassword123');

        [$result, $output] = $this->runAction(
            fn () => (new EmployeeController())->create($this->makeRequest('POST', [
                'login' => '',
                'password' => '',
            ]))
        );

        $this->assertSame('1', $result);
        $this->assertStringContainsString('Поле логин пусто', $output);
        $this->assertStringContainsString('Поле пароль пусто', $output);
    }

    public function testCreateShowsErrorForBusyLogin(): void
    {
        $this->loginAs('autotest_admin_busy', 'adminPassword123');
        $this->createUser('autotest_existing_employee', 'password123', 'employee');

        [$result, $output] = $this->runAction(
            fn () => (new EmployeeController())->create($this->makeRequest('POST', [
                'login' => 'autotest_existing_employee',
                'password' => 'password123',
            ]))
        );

        $this->assertSame('1', $result);
        $this->assertStringContainsString('Поле логин должно быть уникально', $output);
    }

    public function testCreateAddsNewEmployee(): void
    {
        $this->loginAs('autotest_admin_success', 'adminPassword123');

        [$result, $output] = $this->runAction(
            fn () => (new EmployeeController())->create($this->makeRequest('POST', [
                'login' => 'autotest_new_employee',
                'password' => 'validPassword123',
            ]))
        );

        $createdUser = User::where('login', 'autotest_new_employee')->first();

        $this->assertSame('', $result);
        $this->assertSame('', $output);
        $this->assertSame('/employees/create', $this->route->redirectUrl);
        $this->assertNotNull($createdUser);
        $this->assertSame('employee', $createdUser->role->name);

        $createdUser->delete();
    }
}
