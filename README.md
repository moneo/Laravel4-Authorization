# Laravel4 Authorization

This package adds ability to use Policies in Laravel 4. 

## Installation

Install as dependency:

```bash
composer require moneo/laravel4-authorization
```
  
Create a service provider for your application, as in Laravel 5.x in `app/Providers/AuthServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use Moneo\Authorization\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }

}

```
  
Register service providers in `app/config/app.php`

```php
<?php
//...

    'providers' => array(
            //...
            Moneo\Authorization\Foundation\Support\Providers\AuthServiceProvider::class,
            App\Providers\AuthServiceProvider::class,
    ),
//...
```

You can use `AuthorizesRequest` trait in your controllers:

```php
<?php

class UserController {
      use \Moneo\Authorization\Foundation\Auth\Access\AuthorizesRequests;
      
      public function store(User $user) {
          $this->authorize(UserPolicy::UPDATE, $user);
      }
}
```

### Policy Example

```php
<?php

namespace App\Policies;

use Moneo\Authorization\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    const UPDATE = 'update';

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user, User $authenticatedUser)
    {
        return $authenticatedUser->isAdmin() || $user->id === $authenticatedUser->id;
    }
}

```


## To-do:

[ ] Policy generator command
[ ] Vendor publisher
[ ] Trait for Model files - to use `can` method.
