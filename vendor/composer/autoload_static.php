<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited5553e36e77659c64da368e11a43749
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Codechecker\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Codechecker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Codechecker',
        ),
    );

    public static $classMap = array (
        'Codechecker\\Controller\\CodeController' => __DIR__ . '/../..' . '/app/Codechecker/Controller/CodeController.php',
        'Codechecker\\Controller\\UsersController' => __DIR__ . '/../..' . '/app/Codechecker/Controller/UsersController.php',
        'Codechecker\\DB\\UsersModel' => __DIR__ . '/../..' . '/app/Codechecker/DB/UsersModel.php',
        'Codechecker\\DB\\dbconfig' => __DIR__ . '/../..' . '/app/Codechecker/DB/dbconfig.php',
        'Codechecker\\JSON\\OpConverter' => __DIR__ . '/../..' . '/app/Codechecker/JSON/OpConverter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited5553e36e77659c64da368e11a43749::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited5553e36e77659c64da368e11a43749::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited5553e36e77659c64da368e11a43749::$classMap;

        }, null, ClassLoader::class);
    }
}
