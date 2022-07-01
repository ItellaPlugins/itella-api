<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderIniteb694a5ce30c38b2e7cf8e65f539539e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderIniteb694a5ce30c38b2e7cf8e65f539539e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderIniteb694a5ce30c38b2e7cf8e65f539539e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        \Composer\Autoload\ComposerStaticIniteb694a5ce30c38b2e7cf8e65f539539e::getInitializer($loader)();

        $loader->register(true);

        return $loader;
    }
}
