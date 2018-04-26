# Laravel Service Provider for Teamwork

![teamwork-developer](https://developer.teamwork.com/images/logo-api.png)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ciromattia/laravel-teamwork/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ciromattia/laravel-teamwork/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ciromattia/laravel-teamwork/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ciromattia/laravel-teamwork/?branch=master)
[![Build Status](https://travis-ci.org/ciromattia/laravel-teamwork.svg?branch=master)](https://travis-ci.org/ciromattia/laravel-teamwork)
![Release](https://img.shields.io/github/release/ciromattia/teamwork.svg?style=flat)
![License](https://img.shields.io/packagist/l/ciromattia/teamwork.svg?style=flat)

This package aims to implement the [Teamwork API](https://developer.teamwork.com) in a Service Provider for Laravel 5.

## Installation

Add the package through composer:

```
composer require "ciromattia/laravel-teamwork:~1.3"
```

## Laravel Setup

The Service Provider is auto-discoverable by Laravel 5.5+.

If you're using Laravel 5.4 or earlier, you have to manually add the following to your `config/app.php` file.
```php
'providers' => [
    ...
    'Ciromattia\Teamwork\TeamworkServiceProvider',
],
```

and then add the facade to your `aliases` array

```php
'aliases' => [
    ...
    'Teamwork' => 'Ciromattia\Teamwork\Facades\Teamwork',
],
```

### Configuration

Add a `teamwork` array to your `config/services.php` file

```php
...
'teamwork' => [
    'key'  => 'YourSecretKey',
    'url'  => 'YourTeamworkUrl'
],
```

### Use

There are two ways to use this stuff: the first is by the Teamwork Facade, like this

```php
Teamwork::people()->all();
```

If you want to use dependency injection to make your application easy to test, the Service Provider binds `Ciromattia\Teamwork\Factory`. Here is an example of how to use it with dependency injection

```php
Route::get('/test', function(Ciromattia\Teamwork\Factory $teamwork) {
   $activity = $teamwork->activity()->latest();
});
```

#### Methods

The methods available mimic the Teamwork entities in lowercase and query the namesake API, so you can retrieve e.g. a single project with:

```php
Teamwork::project($project_id)->find();
```

Common methods available to all the entities are:
* `all()` - returns all the query results (i.e. all the entity objects).
* `find($id)` - returns a single object with the specified ID.
* `create($data)` - creates a single object with `$data` parameters.  
* `update($data)` - updates a single object with `$data` parameters.
* `delete($id)` - deletes a single object with the specified ID.  
  
The implemented entities at the moment are:
* [Comments](https://developer.teamwork.com/comments)
* [Company](https://developer.teamwork.com/companies)
* [Links](https://developer.teamwork.com/links)
* [Message](https://developer.teamwork.com/message)
* [Milestone](https://developer.teamwork.com/milestone)
* [People](https://developer.teamwork.com/people)
* [Project](https://developer.teamwork.com/projectsapi)
* [Task](https://developer.teamwork.com/todolistitems)
* [Tasklist](https://developer.teamwork.com/tasklists)
* [Time](https://developer.teamwork.com/timetracking)

The following special entities don't have the common methods specified above: 
* [Account](https://developer.teamwork.com/account)
* [Activity](https://developer.teamwork.com/activity)

## Configuration Without Laravel

If you are not using Laravel you can instantiate the class like this

```php
require "vendor/autoload.php";

use GuzzleHttp\Client as Guzzle;
use Ciromattia\Teamwork\Client;
use Ciromattia\Teamwork\Factory as Teamwork;

$client     = new Client(new Guzzle, 'YourSecretKey', 'YourTeamworkUrl');
$teamwork   = new Teamwork($client);
```

You are ready to go now!

* * *

## Examples

Not all of the Teamwork API is supported yet but there is still a lot you can do! Below are some examples of how you can access Projects, Companies, and more. To work with a specific Object pass in the ID to perform actions on it. Data can be passed through for creating and editing.

**To see more examples [visit the docs](http://ciromattia.github.io/laravel-teamwork/)**

```php
// create a project
$teamwork->project()->create([
    "name" => "My New Amazing Project",
    "description" => "This is a project that I will dedicate my whole life too",
    "companyId" => "999"
]);

// get the latest activity on a project
$teamwork->project($projectID)->activity();
```

## Roadmap

#### 2.0 Release
- [ ] Add support for paging
- [X] Add Support For `Comments`
- [ ] Add Support For `Permissions`
- [ ] Add Support For `Categories`
- [ ] Add Support For `People Status`
- [ ] Add Support For `Files`
- [ ] Add Support For `Notebooks`

## Credits
This library is an evolution of the now abandoned [Teamwork 5 PM API Bridge](https://github.com/rossedman/teamwork) by Ross Edman.