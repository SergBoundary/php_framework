<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit407b638bfe7d8151c0ded807f3f5da34
{
    public static $prefixLengthsPsr4 = array (
        'b' => 
        array (
            'basis\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'basis\\' => 
        array (
            0 => __DIR__ . '/..' . '/basis',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'V' => 
        array (
            'Valitron' => 
            array (
                0 => __DIR__ . '/..' . '/vlucas/valitron/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit407b638bfe7d8151c0ded807f3f5da34::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit407b638bfe7d8151c0ded807f3f5da34::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit407b638bfe7d8151c0ded807f3f5da34::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
