# Value Objects & DTOs Complete Guide
## DDD Laravel Implementation

This guide covers all Value Objects and DTOs for User and Access modules.

---

## Value Objects Created

### User Module
1. **Email** - Email validation and parsing
2. **UserName** - Name validation with parsing (first/last name, initials)
3. **Password** - Password validation, hashing, and verification
4. **Avatar** - Image path/URL validation with helpers

### Access Module
1. **RoleName** - Role name validation and formatting
2. **RoleDescription** - Optional description with length limit
3. **GuardName** - Guard validation (web, api, admin)
4. **PermissionName** - Permission format validation (action-resource)

---

## Quick Reference

### Email Value Object
```php
$email = Email::fromString('user@example.com');
$email->getValue();        // user@example.com
$email->getLocalPart();    // user
$email->getDomain();       // example.com
```

### UserName Value Object
```php
$name = UserName::fromString('John Doe');
$name->getValue();         // John Doe
$name->getFirstName();     // John
$name->getLastName();      // Doe
$name->getInitials();      // JD
```

### Password Value Object
```php
$password = Password::fromPlainText('MyP@ss123');
$password->getHashedValue();                    // $2y$10$...
$password->verify('MyP@ss123');                 // true
Password::calculateStrength('MyP@ss123');       // 0-100
```

### Avatar Value Object
```php
$avatar = Avatar::fromPath('avatars/user.jpg');
$avatar->getUrl();         // http://localhost/storage/avatars/user.jpg
$avatar->exists();         // true/false
$avatar->isEmpty();        // true/false
```

### RoleName Value Object
```php
$role = RoleName::fromString('super-admin');
$role->getDisplayName();   // Super Admin
$role->isSystemRole();     // true
```

### GuardName Value Object
```php
$guard = GuardName::web();     // or ::api(), ::admin()
$guard->isWeb();               // true
GuardName::validGuards();      // ['web', 'api', 'admin']
```

### PermissionName Value Object
```php
$permission = PermissionName::fromString('edit-posts');
// or
$permission = PermissionName::create('edit', 'posts');

$permission->getAction();          // edit
$permission->getResource();        // posts
$permission->getDisplayName();     // Edit Posts
$permission->isCrudPermission();   // true
```

---

## DTOs Usage

### CreateUserDTO
```php
$dto = CreateUserDTO::fromArray([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'SecureP@ss123',
    'avatar' => 'avatars/john.jpg',
    'roles' => ['user'],
]);

// In service
$user = $this->userRepository->create($dto->toArray());
```

### CreateRoleDTO
```php
$dto = CreateRoleDTO::fromArray([
    'name' => 'content-manager',
    'guard_name' => 'web',
    'description' => 'Manages content',
    'permissions' => ['view-posts', 'edit-posts']
]);

$displayName = $dto->getDisplayName();  // Content Manager
```

### CreatePermissionDTO
```php
$dto = CreatePermissionDTO::fromArray([
    'name' => 'edit-posts',
    'guard_name' => 'web',
    'group' => 'Content Management',
]);

$action = $dto->getAction();      // edit
$resource = $dto->getResource();  // posts
```

---

## Benefits

### Type Safety
```php
// ❌ Can pass invalid data
public function updateEmail(int $userId, string $email) { }

// ✅ Guaranteed valid
public function updateEmail(int $userId, Email $email) { }
```

### Single Source of Validation
```php
// Validation happens once at Value Object creation
$email = Email::fromString($input);  // Validates here
// If we reach this line, email is valid!
```

### Clear Intent
```php
// ❌ Unclear what these strings represent
function create(string $a, string $b, string $c) { }

// ✅ Crystal clear
function create(UserName $name, Email $email, Password $password) { }
```

---

## All Files Created

1. **User_ValueObjects.php** - Email, UserName, Password, Avatar
2. **Access_ValueObjects.php** - RoleName, RoleDescription, GuardName, PermissionName
3. **User_DTOs_with_ValueObjects.php** - CreateUserDTO, UpdateUserDTO, UpdateProfileDTO
4. **Access_DTOs_with_ValueObjects.php** - CreateRoleDTO, UpdateRoleDTO, CreatePermissionDTO, UpdatePermissionDTO

All Value Objects are:
- ✅ Immutable (final classes, no setters)
- ✅ Self-validating (throw exceptions on invalid data)
- ✅ JSON serializable
- ✅ Comparable by value (equals() method)
- ✅ Type-safe (PHP 8.2+ features)

For complete examples and best practices, see the implementation files!
