# BoldGrid API PHP SDK

Using composer, you can get started quickly:

```php
$ composer require boldgrid/api
```


In your code, use the normal procedures of requiring the autoloader.  This client uses PSR-4 specification for autoloading:

```php
require __DIR__ . '/vendor/autoload.php';
```

Now you can start using the API.  The examples below will assume that your using the namespaces:

```php
use Boldgrid\Reseller\Boldgrid;
```


Then you can kick off by creating a new api call using the default settings:

```shell
$api = new Boldgrid();
```

The endpoint is pointing to production, but you can easily switch this to the Reseller API sandbox endpoints by passing in the sandbox instance to the new Boldgrid constructor like this:

```php
use Boldgrid\Reseller\Environment\Sandbox;

$api = new Boldgrid( new Sandbox );
```

Alternatively, you can this syntax to accomplish the same goal:

```php
use Boldgrid\Reseller\Environment\Sandbox;

$api = new Boldgrid();
$api = $api->setEnvironment( new Sandbox );
```

The calls will utilize token based authentication and look for stored responses in the session data.  You can choose to store the data in memcache instead by passing an instance of a class utilizing the Storage interface.  This example shows how to set the storage to use Memcache instead of Session:

```php
use Boldgrid\Reseller\Environment;
use Boldgrid\Reseller\Storage;

$api = new Boldgrid( new Environment\Sandbox, new Storage\Memcache );
```

Alternatively you can use the following syntax to accomplish the same thing:

```php
use Boldgrid\Reseller\Environment\Sandbox;
use Boldgrid\Reseller\Storage\Memcache;

$api = $api
	->setEnvironment( new Sandbox )
	->setStorage( new Memcache );
```

Using the token based authentication, which is the default auth method - you will need to set the auth params. The tokens have a set expiration of 2 days for the BoldGrid Reseller API, so you will need to provide a way to retrieve the key/secret securely in your application.  This can be done by passing in the key and reseller key, like this:

```php
$api = $api
	->setKey( $key )
	->setResellerKey( $resellerKey );
```

We recommend sticking with the token based authentication for making calls from distributed applications, but you may wish to use other authentication methods when making calls.  If you decide to use one of the other authentication methods you can simply pass the auth type desired to the setAuth method.  The supported types are **token**, **basic**, and **key**.  You can read more about the API authentication methods in our [API documentation](https://boldgrid.com/docs/api).

This example shows how to switch to using Basic Authentication for your call, which will require you to pass in your key and reseller key secret:

```php
$api = $api
	->setAuth( 'basic' )
	->setKey( $key )
	->setResellerKey( $resellerKey );
```

This example shows how to authorize with only the key and reseller key:

```php
$api = $api
	->setAuth( 'key' )
	->setKey( $key )
	->setResellerKey( $resellerKey );
```

Now that you know how to set the environment, authorization, and storage types - you can start making calls utilizing the BoldGrid Reseller API Client.  Each call is segmented to it's base and endpoint.  For instance, if you're looking to make a call to the key/list endpoint, the syntax would be like:

```php
$api->key()->list();
```

Here's an example that sets the environment to the sandbox API, uses token authorization (default ), stores the token in memcache, and generates the key list of the clients under the reseller:

```php
require __DIR__ . '/vendor/autoload.php';

use Boldgrid\Reseller\Boldgrid;
use Boldgrid\Reseller\Environment\Sandbox;
use Boldgrid\Reseller\Storage\Memcache;

$api = new Boldgrid();
$api = $api
	->setEnvironment( new Sandbox )
	->setStorage( new Memcache )
	->setKey( $key )
	->setResellerKey( $resellerKey );

$call = $api
	->key()
	->list();

var_dump( $call ); die;

```

Here's a list of available calls that can be made:

### Auth ###

```php
$api->auth()
	->getToken( $key, $resellerKey );
```

### Coin ###

```php
$api->coin()
	->balance( $connectId );

$api->coin()
	->add( $connectId, $coins );

$api->coin()
	->remove( $connectId, $coins );
```

### Key ###

```php
$api->key()
	->list();

$api->key()
	->details( $connectId );

$api->key()
	->create( $email, $isPremium );

$api->key()
	->suspend( $connectId, $reason );

$api->key()
	->unsuspend( $connectId, $reason );

$api->key()
	->revoke( $connectId );

$api->key()
	->changeType( $connectId, $type );

$api->key()
	->createReseller( $title, $email, $optional );
```

### Site ###

```php
$api->site()
	->list( $connectId, $dateFrom, $dateTo );
```

### User ###

```php
$api->user()
	->update( $connectId, $email, $displayName );
$api->user()
	->updateReseller( $title, $email );
```
