# FitMiddleware

Simply Middleware Implementation.

## Installation

```
composer require fitdev-pro/middleware
```

## Usage

Base usage
```php
<?php
    $hundler = new MiddlewareHundler(new Resolver(), new Queue());

    $hundler->append(Foo/Bar/SomeClass::class);

    $hundler->append(function ($input, $output, $next){
       $data += 1;

       return $next($data);
    });

    $hundler->append(function ($input, $output, $next){
        $data += 2;

        if($data > 4){
            return $data;
        }
        
        return $next($data);
    });

    $hundler->append(function ($input, $output, $next){
        $data += 3;

        return $next($data);
    });
    
    $newData = $hundler->hundle(2);
```

## Contribute

Please feel free to fork and extend existing or add new plugins and send a pull request with your changes!
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.

## License

The MIT License (MIT). Please see [License File](https://github.com/fitdev-pro/middleware/blob/master/LISENCE) for more information.
