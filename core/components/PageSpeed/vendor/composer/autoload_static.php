<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc7bf20f392714edcef62aa9e1fdd8dd
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MimeTyper\\' => 10,
            'MatthiasMullie\\PathConverter\\' => 29,
            'MatthiasMullie\\Minify\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MimeTyper\\' => 
        array (
            0 => __DIR__ . '/..' . '/wgenial/php-mimetyper/src',
        ),
        'MatthiasMullie\\PathConverter\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/path-converter/src',
        ),
        'MatthiasMullie\\Minify\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/minify/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Sabberworm\\CSS' => 
            array (
                0 => __DIR__ . '/..' . '/sabberworm/php-css-parser/lib',
            ),
        ),
        'D' => 
        array (
            'Dflydev\\ApacheMimeTypes' => 
            array (
                0 => __DIR__ . '/..' . '/dflydev/apache-mime-types/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfc7bf20f392714edcef62aa9e1fdd8dd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfc7bf20f392714edcef62aa9e1fdd8dd::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitfc7bf20f392714edcef62aa9e1fdd8dd::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitfc7bf20f392714edcef62aa9e1fdd8dd::$classMap;

        }, null, ClassLoader::class);
    }
}
