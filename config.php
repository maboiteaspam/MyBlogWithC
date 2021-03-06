<?php
return [
//    'debug'               => true,

    'server_type'           => 'builtin',
    'documentRoot'          => '%project.path%/www/',

    'private_build_dir'     => '%project.path%/run/',
    'public_build_dir'      => '%project.path%/www/run/',

    'esi.secret'            => 'secret',
    'form.secret'           => md5(__DIR__.'/run/'),
    'blogdata.provider'     => "Eloquent",
//    'blogdata.provider'   => "PO",

    "security.firewalls"    =>[],

    'monolog.logfile'       => '%run.path%/development.log',

    'httpcache.check_taged_resource_freshness' => !false,

    'caches.options' => [
        'http-store'=>[
//            'driver' => 'redis', // if you prefer
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/http/',
        ],
        'assets-store'=>[
//            'driver'  => 'file',
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/assets/',
        ],
        'intl-fs-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/intl-fs/',
        ],
        'intl-content-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/intl-content/',
        ],
        'capsule-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/capsule/',
        ],
        'layout-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/layout/',
        ],
        'modern-layout-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/modern-layout/',
        ],
        'form-fs-store'=>[
            'driver'    => 'include',
            'cache_dir' => __DIR__ . '/run/form-fs/',
        ],
    ],
    'assets.concat'     => false,
    'assets.build_dir'  => 'www/run',
    'assets.www_dir'    => '/run',
    'assets.patterns' => [
        'blog_detail'   => '/images/blog/detail/:id.jpg',
        'blog_list'     => '/images/blog/list/:id.jpg',
    ],
    'assets.bridge_file_path' => '%project.path%/run/bridge.php',

    'capsule.connections' => [
        "default"=>[
            'driver'    => 'sqlite',
            'database'  => '%project.path%/run/database.sqlite',
//        'database'    => ':memory:',

//        'driver'      => 'mysql',
//        'host'        => '127.0.0.1',
//        'database'    => 'blog',
//        'username'    => 'root',
//        'password'    => '',

            'prefix'    => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        "prod"=>[
            'driver'    => 'sqlite',
//            'database' => '%project.path%/run/database.sqlite',
            'database'  => ':memory:',
            'prefix'    => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];