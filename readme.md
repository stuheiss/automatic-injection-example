# Automatic Injection in Laravel 5.5

## What this repo is about

Laravel is a wonderful prototyping environment that provides lots of shortcuts for developing PHP applications. One of my favorite features is [Automatic Injection](https://laravel.com/docs/5.5/container#automatic-injection) which allows you to easily inject dependencies into controllers, event listeners, queue jobs, middleware, and more. This encourages making testable code and really makes it easy to do. It also encourages programming to an interface making it really easy to swap out an implementation.

This tutorial is intentionally a simple as possible. Some other benefits to automatic injection are the ability to inject dependencies into individual methods as well as classes and contextual injection that enables injecting different implementations depending on context. I'll skip over these in this tutorial but you'll have no problem taking this further once you get a clear understaning of the basics.

## The magic behind automatic injection

Laravel's [Service Container](https://laravel.com/docs/5.5/container) can resolve a typehint to an implementation using reflection, but you don't need to understand how that works to use it. Laravel can figure out what you want with your typehints on its own if you don't program to an interface.

However, programming to an interface is even better as you can create multiple implementations and even inject a particular implementation based on context.

When injecting a dependency by typehinting the interface, you must tell Laravel which implementation you want. This is typically done in the AppServiceProvider's register method.

## Four key steps

1. Create a repository interface.
2. Create an implementation of the interface.
3. Bind the interface to the implementation and register it.
4. Inject the bound interface into its dependent class.

Follow these four steps and you'll have automatic injection using interfaces!

1. The repository interface:

    ```php
    <?php
    // App/Repositories/Contracts/FooRepositoryInterface.php

    namespace App\Repositories\Contracts;

    use App\Repositories\Contracts\FooRepositoryInterface;

    interface FooRepositoryInterface
    {
        public function bar();
    }
    ```

2. The repository implementation:

    ```php
    <?php
    // App/Repositories/FooRepository.php

    namespace App\Repositories;

    use App\Repositories\Contracts\FooRepositoryInterface;
    use App\Repositories\FooRepository;

    class FooRepository implements FooRepositoryInterface
    {
        public function bar()
        {
            return "zip";
        }
    }
    ```

3. Bind the interface and its implementation:

	```php
	// App/Providers/AppServiceProvider.php
	
	namespace App\Providers;
	
	use Illuminate\Support\ServiceProvider;
	use App\Repositories\Contracts\FooRepositoryInterface;
	use App\Repositories\FooRepository;
	
	class AppServiceProvider extentd ServiceProvider
	{
		public function boot()
		{
			//
		}
		
		public function register()
		{
			// bind the interface to the implementation
			$this->app->bind(FooRepositoryInterface::class, FooRepository::class);
		}
	}
	```

4. The controller:

	```php
	<?php
	// in App\Http\Controllers\FooController.php
	
	namespace App\Http\Controllers;
	
	use App\Http\Controllers\FooController;
	use App\Repositories\Contracts\FooRepositoryInterface;
	use App\Repositories\FooRepository;
	
	class FooController extends Controller
	{
	    protected $foo;
	
	    // inject the dependency using the typehint of the interface
	    public function __construct(FooRepositoryInterface $foo)
	    {
	        $this->foo = $foo;
	    }
	
	    public function index()
	    {
	        return $this->foo->bar();
	    }
	}
	```

    Let's add a test.


5. A route to test:

	```php
	// routes/web.php
	Route::get('/foo', 'FooController@index');
	```
	
6. A feature test:

	```php
	<?php
	// tests/Feature/CanSeeFooControllerRenderZipTest.php
	
	namespace Tests\Feature;
	
	use Tests\TestCase;
	use Illuminate\Foundation\Testing\RefreshDatabase;
	
	class CanSeeFooControllerRenderZipTest extends TestCase
	{
	    /**
	     * A basic test example.
	     *
	     * @return void
	     */
	    public function testExample()
	    {
	        $response = $this->get('/foo');
	        $response->assertSeeText('zip');
	    }
	}
	```

Run the test:

```
$ phpunit
```

Let's review: We created a repository that implements an interface. The interface's typehint is injected into the controller. The implemenation is bound to the interface. This is more work than necessary for a single repository but allows us to have multiple implementations in the future and a way to configure the desired implementation by registering a binding. A more sophisticated use-case might be to choose an appropriate implementation based on context. See [Binding Interfaces To Implementations](https://laravel.com/docs/5.5/container#binding-interfaces-to-implementations) and [Contextual Binding](https://laravel.com/docs/5.5/container#contextual-binding) for examples.

Now that we've got the basics covered, let's try a more sophisticated example. We want a repository to provide random numbers but since not all random number generators have the same qualities, we'll create three implementations that conform to a single interface.

## Demo three swappable random number generators

This demo implements a random number controller and three random number generators that can be injected into the controller. Each random number generator has different characteristices. A preferred random generator can be configured in the Service Container.

Each commit of the code represents one of the following steps

1. Initalize a new laravel project

  ```
$ composer create-project --prefer-dist laravel/laravel automatic-injection-example
# -or-
$ laravel new automatic-injection-example
$ (cd automatic-injection-example; git init)
```

2. Create RandomController with method index() that returns a random int between 0 and 100  
   Create a route to /random  
   Create a Feature test to verify the returned random int is between 0 and 100

3. Create RandomRepository to provide a random generator to RandomController

4. Create RandomRepositoryInterface  
   Bind RandomRepositoryInterface to RandomRepository  
   Inject RandomRepositoryInterface into RandomController using automatic injection

5. Create MersenneTwisterRandomRepository for Mersenne Twister Random Number Generator  
   Bind RandomRepositoryInterface to MersenneTwisterRandomRepository

6. Create CsprngRandomRepository for cryptographically secure pseudo-random integers  
   Bind RandomRepositoryInterface to CsprngRandomRepository

## Demo Multiple Automatic Injections

1. Create Foobarzip controller that will be injected with Foo
2. Create Foo repository that will be injected with Bar
3. Demo access method on Bar indirectly through Foo
4. Demo access method on Foo that invokes method on Bar

## Takeaways

Injecting an implementation by type hint is automatic.

Injecting the interface rather than an implementation allows you to choose an implementation by changing the second argument to bind.

You can also use the [when(\<controller\>)->needs(\<interface\>)->give(\<implementation\>)](https://laravel.com/docs/5.5/container#contextual-binding) pattern to create a binding that depends on [context](https://laravel.com/docs/5.5/container#contextual-binding).

## Bonus

Laravel [http-tests](https://laravel.com/docs/5.5/http-tests) are fast and easy to use but have [limited assertions](https://laravel.com/docs/5.5/http-tests#available-assertions). I wanted a simple test that verifies a random number in the range of 0 to 100. This turned out to be fairly easy by examining the rendered content and using [PHPUnit assertions](https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions). I wanted to ensure the random number was both >= 0 and <= 100 as a single assertion. This is possible using assertThat, logicalAnd, greaterThanOrEqual and lessThanOrEqual. See tests/Feature/CanViewRandomNumberTest.php for details.

## Built with laravel 5.5

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
