<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite698c8c177672f9af1375a9c46022474
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite698c8c177672f9af1375a9c46022474::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite698c8c177672f9af1375a9c46022474::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
