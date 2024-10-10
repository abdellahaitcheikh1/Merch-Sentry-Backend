<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        // ---------------------- zenpart -------------------------
        'mysql_second' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_second', '127.0.0.1'),
            'port' => env('DB_PORT_second', '3306'),
            'database' => env('DB_DATABASE_second', 'forge'),
            'username' => env('DB_USERNAME_second', 'forge'),
            'password' => env('DB_PASSWORD_second', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
// -----------------------Quepic---------------------------------------

'mysql_Quepic' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Quepic', '127.0.0.1'),
    'port' => env('DB_PORT_Quepic', '3306'),
    'database' => env('DB_DATABASE_Quepic', 'forge'),
    'username' => env('DB_USERNAME_Quepic', 'forge'),
    'password' => env('DB_PASSWORD_Quepic', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],

//  -------------------------- thalassa --------------------------------------
'mysql_Thalassa_Industriel' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Thalassa_Industriel', '127.0.0.1'),
    'port' => env('DB_PORT_Thalassa_Industriel', '3306'),
    'database' => env('DB_DATABASE_Thalassa_Industriel', 'forge'),
    'username' => env('DB_USERNAME_Thalassa_Industriel', 'forge'),
    'password' => env('DB_PASSWORD_Thalassa_Industriel', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],



// -----------------------------Univers Tracks--------------------------------------

'mysql_Univers_Tracks' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Univers_Tracks', '127.0.0.1'),
    'port' => env('DB_PORT_Univers_Tracks', '3306'),
    'database' => env('DB_DATABASE_Univers_Tracks', 'forge'),
    'username' => env('DB_USERNAME_Univers_Tracks', 'forge'),
    'password' => env('DB_PASSWORD_Univers_Tracks', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],

// -----------------------------Top Engins--------------------------------------

'mysql_Top_Engins' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Top_Engins', '127.0.0.1'),
    'port' => env('DB_PORT_Top_Engins', '3306'),
    'database' => env('DB_DATABASE_Top_Engins', 'forge'),
    'username' => env('DB_USERNAME_Top_Engins', 'forge'),
    'password' => env('DB_PASSWORD_Top_Engins', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],


// ----------------------------Italopieces--------------------------------
'mysql_Italopieces' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Italopieces', '127.0.0.1'),
    'port' => env('DB_PORT_Italopieces', '3306'),
    'database' => env('DB_DATABASE_Italopieces', 'forge'),
    'username' => env('DB_USERNAME_Italopieces', 'forge'),
    'password' => env('DB_PASSWORD_Italopieces', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -----------------------Intereuropieces--------------------------------
'mysql_Intereuropieces' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Intereuropieces', '127.0.0.1'),
    'port' => env('DB_PORT_Intereuropieces', '3306'),
    'database' => env('DB_DATABASE_Intereuropieces', 'forge'),
    'username' => env('DB_USERNAME_Intereuropieces', 'forge'),
    'password' => env('DB_PASSWORD_Intereuropieces', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ----------------------M_ali_Parts-------------------------------

'mysql_M_ali_Parts' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_M_ali_Parts', '127.0.0.1'),
    'port' => env('DB_PORT_M_ali_Parts', '3306'),
    'database' => env('DB_DATABASE_M_ali_Parts', 'forge'),
    'username' => env('DB_USERNAME_M_ali_Parts', 'forge'),
    'password' => env('DB_PASSWORD_M_ali_Parts', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -------------------------J_cat_Equipement--------------------------------
'mysql_J_cat_Equipement' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_J_cat_Equipement', '127.0.0.1'),
    'port' => env('DB_PORT_J_cat_Equipement', '3306'),
    'database' => env('DB_DATABASE_J_cat_Equipement', 'forge'),
    'username' => env('DB_USERNAME_J_cat_Equipement', 'forge'),
    'password' => env('DB_PASSWORD_J_cat_Equipement', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],



// -------------------------Sothad--------------------------------
'mysql_Sothad' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Sothad', '127.0.0.1'),
    'port' => env('DB_PORT_Sothad', '3306'),
    'database' => env('DB_DATABASE_Sothad', 'forge'),
    'username' => env('DB_USERNAME_Sothad', 'forge'),
    'password' => env('DB_PASSWORD_Sothad', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -------------------------Elyoubi--------------------------------
'mysql_Elyoubi' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Elyoubi', '127.0.0.1'),
    'port' => env('DB_PORT_Elyoubi', '3306'),
    'database' => env('DB_DATABASE_Elyoubi', 'forge'),
    'username' => env('DB_USERNAME_Elyoubi', 'forge'),
    'password' => env('DB_PASSWORD_Elyoubi', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -------------------------Saiss_Tracks--------------------------------
'mysql_Saiss_Tracks' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Saiss_Tracks', '127.0.0.1'),
    'port' => env('DB_PORT_Saiss_Tracks', '3306'),
    'database' => env('DB_DATABASE_Saiss_Tracks', 'forge'),
    'username' => env('DB_USERNAME_Saiss_Tracks', 'forge'),
    'password' => env('DB_PASSWORD_Saiss_Tracks', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -------------------------ATI--------------------------------
'mysql_ATI' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_ATI', '127.0.0.1'),
    'port' => env('DB_PORT_ATI', '3306'),
    'database' => env('DB_DATABASE_ATI', 'forge'),
    'username' => env('DB_USERNAME_ATI', 'forge'),
    'password' => env('DB_PASSWORD_ATI', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// --------------------Forcat-------------------------------------------

'mysql_Forcat' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Forcat', '127.0.0.1'),
    'port' => env('DB_PORT_Forcat', '3306'),
    'database' => env('DB_DATABASE_Forcat', 'forge'),
    'username' => env('DB_USERNAME_Forcat', 'forge'),
    'password' => env('DB_PASSWORD_Forcat', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],

// ----------------------------Hydro Mec du Nord----------------------------------

'mysql_Hydro_Mec_du_Nord' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Hydro_Mec_du_Nord', '127.0.0.1'),
    'port' => env('DB_PORT_Hydro_Mec_du_Nord', '3306'),
    'database' => env('DB_DATABASE_Hydro_Mec_du_Nord', 'forge'),
    'username' => env('DB_USERNAME_Hydro_Mec_du_Nord', 'forge'),
    'password' => env('DB_PASSWORD_Hydro_Mec_du_Nord', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// -----------------------------Msemrir----------------------------------

'mysql_Msemrir' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Msemrir', '127.0.0.1'),
    'port' => env('DB_PORT_Msemrir', '3306'),
    'database' => env('DB_DATABASE_Msemrir', 'forge'),
    'username' => env('DB_USERNAME_Msemrir', 'forge'),
    'password' => env('DB_PASSWORD_Msemrir', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ----------------------------Tractonord---------------------------------

'mysql_Tractonord' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Tractonord', '127.0.0.1'),
    'port' => env('DB_PORT_Tractonord', '3306'),
    'database' => env('DB_DATABASE_Tractonord', 'forge'),
    'username' => env('DB_USERNAME_Tractonord', 'forge'),
    'password' => env('DB_PASSWORD_Tractonord', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ---------------------------Tract Park----------------------------------
'mysql_Tract_Park' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Tract_Park', '127.0.0.1'),
    'port' => env('DB_PORT_Tract_Park', '3306'),
    'database' => env('DB_DATABASE_Tract_Park', 'forge'),
    'username' => env('DB_USERNAME_Tract_Park', 'forge'),
    'password' => env('DB_PASSWORD_Tract_Park', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ---------------------------Souss_Plus-------------------------------------
'mysql_Souss_Plus' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Souss_Plus', '127.0.0.1'),
    'port' => env('DB_PORT_Souss_Plus', '3306'),
    'database' => env('DB_DATABASE_Souss_Plus', 'forge'),
    'username' => env('DB_USERNAME_Souss_Plus', 'forge'),
    'password' => env('DB_PASSWORD_Souss_Plus', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ---------------------------Mondial_Engins-------------------------------------
'mysql_Mondial_Engins' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Mondial_Engins', '127.0.0.1'),
    'port' => env('DB_PORT_Mondial_Engins', '3306'),
    'database' => env('DB_DATABASE_Mondial_Engins', 'forge'),
    'username' => env('DB_USERNAME_Mondial_Engins', 'forge'),
    'password' => env('DB_PASSWORD_Mondial_Engins', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ---------------------------Elhachimi-------------------------------------
'mysql_Elhachimi' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Elhachimi', '127.0.0.1'),
    'port' => env('DB_PORT_Elhachimi', '3306'),
    'database' => env('DB_DATABASE_Elhachimi', 'forge'),
    'username' => env('DB_USERNAME_Elhachimi', 'forge'),
    'password' => env('DB_PASSWORD_Elhachimi', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ---------------------------Cica-------------------------------------
'mysql_Cica' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST_Cica', '127.0.0.1'),
    'port' => env('DB_PORT_Cica', '3306'),
    'database' => env('DB_DATABASE_Cica', 'forge'),
    'username' => env('DB_USERNAME_Cica', 'forge'),
    'password' => env('DB_PASSWORD_Cica', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
// ----------------------------------------------------------------



        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],
        // 'new' => [
        //     'driver' => 'mysql',
        //     'host' => env('DB_HOST', '127.0.0.1'),
        //     'port' => env('DB_PORT', '3306'),
        //     'database' => '', // Leave empty as it will be dynamically set
        //     'username' => env('DB_USERNAME', 'forge'),
        //     'password' => env('DB_PASSWORD', ''),
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        //     'strict' => true,
        //     'engine' => null,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
