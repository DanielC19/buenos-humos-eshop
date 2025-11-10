<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private function createMockUser(
        string $name = 'John',
        string $lastname = 'Doe',
        string $email = 'test@example.com',
        string $phone = '1234567890',
        UserRole $role = UserRole::USER
    ): User {
        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();

        $user->setName($name);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setRole($role);

        return $user;
    }

    public function test_is_admin_returns_true_for_admin_user(): void
    {
        // Given: An admin user
        $admin = $this->createMockUser(role: UserRole::ADMIN);

        // When: Check if user is admin
        $isAdmin = $admin->isAdmin();

        // Then: Should return true
        $this->assertTrue($isAdmin);
    }

    public function test_is_admin_returns_false_for_customer_user(): void
    {
        // Given: A customer user
        $customer = $this->createMockUser(role: UserRole::USER);

        // When: Check if user is admin
        $isAdmin = $customer->isAdmin();

        // Then: Should return false
        $this->assertFalse($isAdmin);
    }

    public function test_get_full_name_concatenates_name_and_lastname(): void
    {
        // Given: A user with name and lastname
        $user = $this->createMockUser(name: 'John', lastname: 'Doe');

        // When: Get full name
        $fullName = $user->getFullName();

        // Then: Should concatenate with space
        $this->assertEquals('John Doe', $fullName);
    }

    public function test_get_role_returns_correct_enum(): void
    {
        // Given: An admin user
        $admin = $this->createMockUser(role: UserRole::ADMIN);

        // When: Get role
        $role = $admin->getRole();

        // Then: Should return UserRole enum
        $this->assertInstanceOf(UserRole::class, $role);
        $this->assertEquals(UserRole::ADMIN, $role);
    }

    public function test_set_role_updates_user_role(): void
    {
        // Given: A user with USER role
        $user = $this->createMockUser(role: UserRole::USER);

        // When: Change role to admin
        $user->setRole(UserRole::ADMIN);

        // Then: Role should be updated
        $this->assertEquals(UserRole::ADMIN, $user->getRole());
        $this->assertTrue($user->isAdmin());
    }
}
