<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit918e13626662aec59d078cb7d91513e5
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/MF',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit918e13626662aec59d078cb7d91513e5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit918e13626662aec59d078cb7d91513e5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
