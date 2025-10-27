# Exception Handling Guide for DDD Laravel Project

## Overview
This guide covers all custom exceptions for the User and Access (Role/Permission) modules following DDD principles.

---

## Table of Contents
1. [User Exceptions](#user-exceptions)
2. [Access Exceptions](#access-exceptions)
3. [Exception Handler](#exception-handler)
4. [Usage Examples](#usage-examples)
5. [Best Practices](#best-practices)

---

## User Exceptions

### Base Exception
```php
UserException extends Exception
```
All user-related exceptions extend this base class.

### 1. UserNotFoundException (404)
**When to use:** User doesn't exist in the database

**Static constructors:**
```php
UserNotFoundException::withId(1)
// "User with ID 1 not found"

UserNotFoundException::withEmail('user@example.com')
// "User with email user@example.com not found"
```

**Usage in service:**
```php
public function getUserById(int $id)
{
    $user = $this->userRepository->findById($id);
    
    if (!$user) {
        throw UserNotFoundException::withId($id);
    }
    
    return $user;
}
```

### 2. UserAlreadyExistsException (409)
**When to use:** Attempting to create a user that already exists

```php
UserAlreadyExistsException::withEmail('user@example.com')
// "User with email user@example.com already exists"
```

**Usage:**
```php
public function createUser(CreateUserDTO $dto)
{
    if ($this->userRepository->findByEmail($dto->email)) {
        throw UserAlreadyExistsException::withEmail($dto->email);
    }
    
    // Create user...
}
```

### 3. InvalidUserDataException (422)
**When to use:** User data validation fails

```php
InvalidUserDataException::missingField('email')
// "Required field 'email' is missing"

InvalidUserDataException::invalidField('age', 'must be between 18 and 120')
// "Field 'age' is invalid: must be between 18 and 120"
```

### 4. UserInactiveException (403)
**When to use:** User account is deactivated

```php
UserInactiveException::withId(1)
// "User with ID 1 is inactive"
```

### 5. UserNotVerifiedException (403)
**When to use:** Email verification required

```php
throw new UserNotVerifiedException('User email is not verified');
```

### 6. UserDeletionException (400)
**When to use:** Cannot delete user due to constraints

```php
UserDeletionException::hasActiveData()
// "Cannot delete user with active data. Please archive or transfer data first."

UserDeletionException::isSystemUser()
// "Cannot delete system user"
```

### 7. InvalidPasswordException (422)
**When to use:** Password validation fails

```php
InvalidPasswordException::tooShort(8)
// "Password must be at least 8 characters long"

InvalidPasswordException::tooWeak()
// "Password is too weak. Must contain uppercase, lowercase, numbers, and special characters"
```

### 8. InvalidEmailException (422)
**When to use:** Email validation fails

```php
InvalidEmailException::format('invalid-email')
// "Email address 'invalid-email' has invalid format"

InvalidEmailException::domain('user@blocked-domain.com')
// "Email domain for 'user@blocked-domain.com' is not allowed"
```

### 9. ProfileNotFoundException (404)
**When to use:** User profile doesn't exist

```php
ProfileNotFoundException::forUser(1)
// "Profile for user ID 1 not found"
```

### 10. ProfileUpdateException (400)
**When to use:** Profile update fails

```php
throw new ProfileUpdateException('Failed to update profile');
```

### 11. AvatarUploadException (400)
**When to use:** Avatar upload fails

```php
AvatarUploadException::invalidFileType()
// "Avatar must be an image file (jpg, jpeg, png, gif)"

AvatarUploadException::fileTooLarge(5)
// "Avatar file size must not exceed 5MB"
```

### 12. UserPermissionException (403)
**When to use:** Permission-related errors

```php
UserPermissionException::missing('edit-posts')
// "User does not have 'edit-posts' permission"

UserPermissionException::cannotAssign('super-admin')
// "Cannot assign 'super-admin' permission to user"
```

### 13. UserRoleException (403)
**When to use:** Role-related errors

```php
UserRoleException::cannotAssign('admin')
// "Cannot assign 'admin' role to user"

UserRoleException::cannotRemove('owner')
// "Cannot remove 'owner' role from user"

UserRoleException::systemRole()
// "Cannot modify system role assignment"
```

### 14. BulkOperationException (400)
**When to use:** Bulk operations fail for some users

```php
BulkOperationException::withFailedIds([1, 5, 10], 'role assignment')
// "Bulk role assignment failed for 3 user(s)"

// Access failed IDs:
$exception->getFailedIds(); // [1, 5, 10]
```

---

## Access Exceptions

### Role Exceptions

### 1. RoleNotFoundException (404)
```php
RoleNotFoundException::withId(1)
RoleNotFoundException::withName('admin')
RoleNotFoundException::withNameAndGuard('admin', 'web')
```

### 2. RoleAlreadyExistsException (409)
```php
RoleAlreadyExistsException::withName('admin')
RoleAlreadyExistsException::withNameAndGuard('admin', 'web')
```

### 3. InvalidRoleDataException (422)
```php
InvalidRoleDataException::missingField('name')
InvalidRoleDataException::invalidField('name', 'contains invalid characters')
InvalidRoleDataException::invalidName('admin@123')
```

### 4. SystemRoleException (403)
```php
SystemRoleException::cannotUpdate('super-admin')
SystemRoleException::cannotDelete('super-admin')
SystemRoleException::cannotModify('super-admin')
```

### 5. RoleDeletionException (400)
```php
RoleDeletionException::hasUsers('admin', 5)
// "Cannot delete role 'admin' assigned to 5 user(s). Remove users first or use force delete."

RoleDeletionException::isSystem('super-admin')
```

### 6. RoleAssignmentException (400)
```php
RoleAssignmentException::toUser('admin', 1)
RoleAssignmentException::guardMismatch('admin', 'web', 'api')
RoleAssignmentException::insufficientPrivileges()
```

### 7. RoleHierarchyException (403)
```php
RoleHierarchyException::cannotAssignHigherRole('manager', 'admin')
RoleHierarchyException::cannotModifyHigherRole('manager', 'admin')
```

### Permission Exceptions

### 1. PermissionNotFoundException (404)
```php
PermissionNotFoundException::withId(1)
PermissionNotFoundException::withName('edit-posts')
PermissionNotFoundException::withNameAndGuard('edit-posts', 'web')
```

### 2. PermissionAlreadyExistsException (409)
```php
PermissionAlreadyExistsException::withName('edit-posts')
PermissionAlreadyExistsException::withNameAndGuard('edit-posts', 'web')
```

### 3. InvalidPermissionDataException (422)
```php
InvalidPermissionDataException::missingField('name')
InvalidPermissionDataException::invalidField('name', 'contains invalid characters')
InvalidPermissionDataException::invalidName('edit posts')
// "Permission name 'edit posts' is invalid. Use format: action-resource (e.g., view-posts)"
```

### 4. SystemPermissionException (403)
```php
SystemPermissionException::cannotUpdate('super-admin-access')
SystemPermissionException::cannotDelete('super-admin-access')
SystemPermissionException::cannotModify('super-admin-access')
```

### 5. PermissionDeletionException (400)
```php
PermissionDeletionException::inUse('edit-posts', 3, 5)
// "Cannot delete permission 'edit-posts' assigned to 3 role(s) and 5 user(s). 
// Remove assignments first or use force delete."

PermissionDeletionException::isSystem('super-admin-access')
```

### 6. PermissionAssignmentException (400)
```php
PermissionAssignmentException::toRole('edit-posts', 'viewer')
PermissionAssignmentException::toUser('delete-users', 1)
PermissionAssignmentException::guardMismatch('edit-posts', 'web', 'api')
```

### 7. PermissionGroupException (400)
```php
PermissionGroupException::notFound('Content Management')
PermissionGroupException::invalid('Invalid Group')
```

### 8. PermissionDependencyException (400)
```php
PermissionDependencyException::missing('delete-posts', ['view-posts', 'edit-posts'])
// "Permission 'delete-posts' requires the following permissions: view-posts, edit-posts"

PermissionDependencyException::circular('permission-a', 'permission-b')
```

### General Access Exceptions

### 1. GuardNotFoundException (404)
```php
GuardNotFoundException::withName('custom-guard')
```

### 2. UnauthorizedAccessException (403)
```php
UnauthorizedAccessException::missingPermission('edit-posts')
UnauthorizedAccessException::missingRole('admin')
UnauthorizedAccessException::insufficientPrivileges()
```

### 3. CacheException (500)
```php
CacheException::clearFailed()
```

### 4. BulkAccessOperationException (400)
```php
BulkAccessOperationException::withFailedItems([1, 2, 3], 'permission assignment', 'role')
// "Bulk permission assignment failed for 3 role(s)"

// Access failed items:
$exception->getFailedItems(); // [1, 2, 3]
```

### 5. SyncException (400)
```php
SyncException::rolePermissions('admin')
SyncException::userRoles(1)
SyncException::userPermissions(1)
```

---

## Exception Handler

### Setup

**Option 1: Add to existing Handler.php**
```php
// app/Exceptions/Handler.php

use Modules\Core\User\Presentation\Exceptions\DomainExceptionHandler;

class Handler extends DomainExceptionHandler
{
    // Your existing code...
}
```

**Option 2: Manual registration**
```php
// app/Exceptions/Handler.php

public function register(): void
{
    $this->renderable(function (UserNotFoundException $e, Request $request) {
        return response()->json([
            'success' => false,
            'error' => [
                'type' => 'UserNotFoundException',
                'message' => $e->getMessage(),
                'code' => 404,
            ]
        ], 404);
    });
    
    // Add other exceptions...
}
```

### Response Format

All exceptions return consistent JSON responses:

```json
{
    "success": false,
    "error": {
        "type": "UserNotFoundException",
        "message": "User with ID 1 not found",
        "code": 404
    }
}
```

In debug mode, additional information is included:
```json
{
    "success": false,
    "error": {
        "type": "UserNotFoundException",
        "message": "User with ID 1 not found",
        "code": 404,
        "file": "/path/to/file.php",
        "line": 123,
        "trace": "..."
    }
}
```

---

## Usage Examples

### Example 1: Service with Exception Handling
```php
namespace Modules\Core\User\Application\Services;

use Modules\Core\User\Domain\Exceptions\{
    UserNotFoundException,
    UserAlreadyExistsException,
    InvalidPasswordException
};

class UserService
{
    public function createUser(CreateUserDTO $dto)
    {
        // Check if user exists
        if ($this->userRepository->findByEmail($dto->email)) {
            throw UserAlreadyExistsException::withEmail($dto->email);
        }

        // Validate password
        if (strlen($dto->password) < 8) {
            throw InvalidPasswordException::tooShort(8);
        }

        // Create user
        return $this->userRepository->create([...]);
    }

    public function getUserById(int $id)
    {
        $user = $this->userRepository->findById($id);
        
        if (!$user) {
            throw UserNotFoundException::withId($id);
        }

        if (!$user->is_active) {
            throw UserInactiveException::withId($id);
        }

        return $user;
    }
}
```

### Example 2: Controller with HandlesExceptions Trait
```php
namespace App\Http\Controllers;

use Modules\Core\User\Presentation\Exceptions\HandlesExceptions;
use Modules\Core\User\Application\Services\UserService;

class UserController extends Controller
{
    use HandlesExceptions;

    public function __construct(
        private UserService $userService
    ) {}

    public function show(int $id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return $this->successResponse($user, 'User retrieved successfully');
        } catch (\Exception $e) {
            // Exception handler will catch specific exceptions
            throw $e;
        }
    }

    public function store(CreateUserRequest $request)
    {
        $dto = CreateUserDTO::fromRequest($request->validated());
        $user = $this->userService->createUser($dto);
        
        return $this->successResponse($user, 'User created successfully', 201);
    }
}
```

### Example 3: Bulk Operations with Partial Failures
```php
public function bulkAssignRole(array $userIds, string $role)
{
    $failedIds = [];
    
    DB::beginTransaction();
    try {
        foreach ($userIds as $userId) {
            try {
                $user = $this->userRepository->findOrFail($userId);
                $user->assignRole($role);
            } catch (\Exception $e) {
                $failedIds[] = $userId;
            }
        }
        
        if (!empty($failedIds)) {
            DB::rollBack();
            throw BulkOperationException::withFailedIds($failedIds, 'role assignment');
        }
        
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}
```

### Example 4: Permission Dependency Validation
```php
public function assignPermission(int $userId, string $permission)
{
    $user = $this->userRepository->findOrFail($userId);
    
    // Check dependencies
    $dependencies = $this->getPermissionDependencies($permission);
    $missing = [];
    
    foreach ($dependencies as $dependency) {
        if (!$user->hasPermissionTo($dependency)) {
            $missing[] = $dependency;
        }
    }
    
    if (!empty($missing)) {
        throw PermissionDependencyException::missing($permission, $missing);
    }
    
    $user->givePermissionTo($permission);
    return $user;
}
```

### Example 5: Role Hierarchy Validation
```php
public function assignRoleToUser(int $userId, string $roleName, User $assigner)
{
    $role = Role::findByName($roleName);
    $user = $this->userRepository->findOrFail($userId);
    
    // Check hierarchy
    $assignerRole = $assigner->roles->first();
    
    if ($this->isRoleHigher($roleName, $assignerRole->name)) {
        throw RoleHierarchyException::cannotAssignHigherRole(
            $assignerRole->name,
            $roleName
        );
    }
    
    $user->assignRole($role);
    return $user;
}
```

---

## Best Practices

### 1. Always Use Static Constructors
```php
// ❌ Bad
throw new UserNotFoundException("User not found");

// ✅ Good
throw UserNotFoundException::withId($id);
```

### 2. Catch Specific Exceptions
```php
// ❌ Bad
try {
    $user = $this->userService->getUserById($id);
} catch (\Exception $e) {
    return response()->json(['error' => 'Something went wrong']);
}

// ✅ Good
try {
    $user = $this->userService->getUserById($id);
} catch (UserNotFoundException $e) {
    return response()->json(['error' => $e->getMessage()], 404);
} catch (UserInactiveException $e) {
    return response()->json(['error' => $e->getMessage()], 403);
}
```

### 3. Provide Context in Exception Messages
```php
// ❌ Bad
throw new UserNotFoundException("Not found");

// ✅ Good
throw UserNotFoundException::withEmail($email);
```

### 4. Don't Catch and Re-throw Without Adding Value
```php
// ❌ Bad
try {
    $user = $this->userRepository->findOrFail($id);
} catch (\Exception $e) {
    throw $e; // Pointless
}

// ✅ Good - Just let it bubble up
$user = $this->userRepository->findOrFail($id);

// ✅ Also Good - Add context
try {
    $user = $this->userRepository->findOrFail($id);
} catch (ModelNotFoundException $e) {
    throw UserNotFoundException::withId($id);
}
```

### 5. Log Appropriately
```php
// Important errors should be logged
try {
    $user = $this->userService->createUser($dto);
} catch (UserAlreadyExistsException $e) {
    // Don't log - expected behavior
    throw $e;
} catch (\Exception $e) {
    // Log unexpected errors
    Log::error('Unexpected error creating user', [
        'dto' => $dto,
        'exception' => $e->getMessage()
    ]);
    throw $e;
}
```

### 6. Use Transactions for Complex Operations
```php
DB::beginTransaction();
try {
    $user = $this->userRepository->create($data);
    $user->profile()->create($profileData);
    $user->assignRole($roles);
    
    DB::commit();
    return $user;
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

### 7. Validate Early
```php
public function createUser(CreateUserDTO $dto)
{
    // Validate first
    if ($this->userRepository->findByEmail($dto->email)) {
        throw UserAlreadyExistsException::withEmail($dto->email);
    }

    if (strlen($dto->password) < 8) {
        throw InvalidPasswordException::tooShort(8);
    }

    // Then create
    return $this->userRepository->create([...]);
}
```

### 8. Don't Expose Sensitive Information
```php
// ❌ Bad
throw new Exception("Database error: " . $dbError);

// ✅ Good
Log::error('Database error', ['error' => $dbError]);
throw new Exception("An error occurred while processing your request");
```

---

## Testing Exceptions

```php
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_throws_exception_when_user_not_found()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('User with ID 999 not found');
        
        $this->userService->getUserById(999);
    }

    public function test_throws_exception_when_user_already_exists()
    {
        $this->expectException(UserAlreadyExistsException::class);
        
        $dto = new CreateUserDTO(
            name: 'Test',
            email: 'existing@example.com',
            password: 'password'
        );
        
        $this->userService->createUser($dto);
    }

    public function test_bulk_operation_returns_failed_ids()
    {
        try {
            $this->userService->bulkAssignRole([1, 999, 1000], 'admin');
            $this->fail('Expected BulkOperationException');
        } catch (BulkOperationException $e) {
            $this->assertEquals([999, 1000], $e->getFailedIds());
        }
    }
}
```

---

## Summary

This exception system provides:

✅ **Type Safety** - Specific exceptions for each error case
✅ **Consistency** - Standard response format across all exceptions
✅ **Context** - Static constructors provide detailed error messages
✅ **HTTP Compliance** - Appropriate status codes (404, 409, 422, etc.)
✅ **Debugging** - Enhanced error details in debug mode
✅ **Logging** - Automatic logging of critical errors
✅ **Testability** - Easy to test specific exception scenarios
✅ **Maintainability** - Clear error hierarchy and organization
✅ **DDD Alignment** - Exceptions live in the Domain layer
✅ **Developer Experience** - Helpful error messages and static constructors
