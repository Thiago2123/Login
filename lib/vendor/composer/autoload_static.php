<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf5da6342d4a713d9283dde3c9dc06a73
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf5da6342d4a713d9283dde3c9dc06a73::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf5da6342d4a713d9283dde3c9dc06a73::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf5da6342d4a713d9283dde3c9dc06a73::$classMap;

        }, null, ClassLoader::class);
    }
}
