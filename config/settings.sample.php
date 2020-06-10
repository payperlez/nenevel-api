<?php
    # All configurations can be found in here.

    # Load sensitive data
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    $dbopts = parse_url(getenv('DATABASE_URL'));

    define('RUNTIME_ENVIRONMENT', getenv('RUNTIME_ENVIRONMENT'));
    define('APP_TYPE', 'api'); 

    # Database constants ...
    define('DATABASE',
        serialize(
            array(
                'type' => $dbopts['scheme'],
                'host' => $dbopts['host'],
                'name' => ltrim($dbopts['path'], '/'),
                'user' => $dbopts['user'],
                'passwd' => $dbopts['pass'],
                'persistent' => false
            )
        )
    );

    # Either use the propelorm or not ...
    # This will be changed very soon to include other orms ...
    define('USE_ORM', false);

    # Secret key. Make sure you don't change this key whilst in production ....
    # Used mostly for hashing ...
    # You could add more hash keys by just defining one.
    define('SECRET_KEY', getenv('SECRET_KEY'));

    # Paths. Make sure you put a trailing slash(/) infront of all your paths!!!
    define('BASE_URL', 'http://' . getenv('DOMAIN') . '/');
    