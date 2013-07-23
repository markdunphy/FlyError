## Fly Error [![Build Status](https://travis-ci.org/markdunphy/FlyError.png?branch=master)](https://travis-ci.org/markdunphy/FlyError)
#### A simple error management system stored in PHP sessions.

### Get Moving
##### Setting errors
```php
// Initialize a new FlyError object
$fly = new FlyError();

// Push a single error onto the error stack without redirecting the user to an error page.
$error = 'Email address failed to validate!';
$fly->push( $error );

// Push an array of errors onto the stack and redirect the user to error.php
$errors = array(
  'Email address failed to validate!',
  'Password does not meet criteria.',
  'Date of birth was not filled out'
);

$redirect = 'error.php';
$fly->push( $errors, $redirect );

// Overwrite the current errors in session with an array of errors
$errors = array(
  'Hair is not long enough.',
  'Cat smells funny'
);
$fly->set( $errors ); // Can also redirect by passing a location as a second parameter
```

#####Retrieving/displaying
```php
// Display all the errors and remove them from the session when finished.
// Pass in FALSE to not unset errors after printing.
$fly->display();

// Return all errors in an array
$errors = $fly->all();
```

#####Unsetting
```php
// Unset all errors from session
$fly->clear();
```

#####Checking
```php
// Check if there are any errors
if ( $fly->hasErrors() )
{
  print 'Whoa there\'s some errors!';
}
```
