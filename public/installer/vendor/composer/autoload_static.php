<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit80a04bc88b44289001dfeadc63607bcb
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'sixlive\\DotenvEditor\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'sixlive\\DotenvEditor\\' => 
        array (
            0 => __DIR__ . '/..' . '/sixlive/dotenv-editor/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit80a04bc88b44289001dfeadc63607bcb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit80a04bc88b44289001dfeadc63607bcb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
