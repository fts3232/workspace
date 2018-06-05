<?php

namespace Vendor;

use Composer\Script\Event;

class Installer
{
    private static $backEndFrameMap = array(
        0 => 'laravel/laravel',
        1 => 'laravel/lumen'
    );
    private static $frontEndFrameMap = array(
        0 => 'vue',
        1 => 'react'
    );
    private static $phpVersionMap = array(
        0 => '5.6',
        1 => '7.0'
    );

    private static $installPath = null;

    private static $frontEndFrame = null;

    private static $cwd = null;

    public static function install(Event $event)
    {
        header('Content-type:text/html;charset=utf-8');
        self::$cwd = dirname(__FILE__);
        $io = $event->getIO();

        $backEnd = $io->select('Please Select PHP Frame:', self::$backEndFrameMap, 0);
        $backEndFrame = self::$backEndFrameMap[$backEnd];

        $phpVersion = $io->select('PHP Version:', self::$phpVersionMap, 0);
        if ($phpVersion == 0) {
            $backEndFrame .= '=5.4.*';
        }

        $installPath = $io->askAndValidate('Install Directory:', function ($v) {
            if (empty($v)) {
                throw new \Exception('Directory name can not be empty');
            }
            if (is_dir($v)) {
                throw new \Exception('Directory Already Exists');
            }
            return $v;
        });

        $frontEnd = $io->select('Please Select Front End Frame:', self::$frontEndFrameMap, 0);
        self::$frontEndFrame = self::$frontEndFrameMap[$frontEnd];

        $installCmd = "composer create-project --prefer-dist {$backEndFrame} {$installPath}";
        exec($installCmd);

        self::$installPath = $installPath . '/';

        self::mkDirs();

        self::npmInit();

        if (self::$frontEndFrame == 'vue') {
            self::vueInit();
        }
    }

    private static function mkDirs()
    {
        if (!is_dir(self::$installPath . 'resources/assets/template/')) {
            mkdir(self::$installPath . 'resources/assets/template/', 0777, true);
        }
        if (!is_dir(self::$installPath . 'resources/assets/css/')) {
            mkdir(self::$installPath . 'resources/assets/css/', 0777, true);
        }
        if (!is_dir(self::$installPath . 'resources/assets/sass/')) {
            mkdir(self::$installPath . 'resources/assets/sass/', 0777, true);
        }
        if (!is_dir(self::$installPath . 'resources/assets/js/')) {
            mkdir(self::$installPath . 'resources/assets/js/', 0777, true);
        }
        if (!is_dir(self::$installPath . 'resources/assets/images/')) {
            mkdir(self::$installPath . 'resources/assets/images/', 0777, true);
        }
    }

    private static function npmInit()
    {
        $package = json_decode(file_get_contents(self::$cwd . '/npm/package.json'), true);
        $package['scripts']['build:dev'] = preg_replace_callback_array(
            [
                '/--build-path=.* /' => function ($match) {
                    return '--build-path=public ';
                },
                '/--src-path=.* ?/' => function ($match) {
                    return '--src-path=resources/assets ';
                }
            ],
            $package['scripts']['build:dev']
        );
        $package['scripts']['start:dev'] = preg_replace_callback_array(
            [
                '/--build-path=.* /' => function ($match) {
                    return '--build-path=public ';
                },
                '/--src-path=.* ?/' => function ($match) {
                    return '--src-path=resources/assets ';
                }
            ],
            $package['scripts']['start:dev']
        );
        $package['scripts']['build:pro'] = preg_replace_callback_array(
            [
                '/--build-path=.* /' => function ($match) {
                    return '--build-path=public ';
                },
                '/--src-path=.* ?/' => function ($match) {
                    return '--src-path=resources/assets ';
                }
            ],
            $package['scripts']['build:pro']
        );
        file_put_contents(self::$installPath . 'package.json', json_encode($package, JSON_PRETTY_PRINT));

        $webpackConfig = file_get_contents(self::$cwd . '/npm/webpack.config.babel.js');
        $webpackConfig = preg_replace(
            "/filename: 'index.html'/",
            "filename: arg.mode == 'development' ? 'index.html' : SRC_PATH + '/../views/index.blade.php'",
            $webpackConfig
        );
        file_put_contents(self::$installPath . 'webpack.config.babel.js', $webpackConfig);

        copy(self::$cwd . '/npm/postcss.config.js', self::$installPath . 'postcss.config.js');
        copy(self::$cwd . '/npm/.babelrc', self::$installPath . '.babelrc');
    }

    private static function vueInit()
    {
        copy(
            self::$cwd . "/front_end/vue/template/index.html",
            self::$installPath . 'resources/assets/template/index.html'
        );

        self::copyDir(
            self::$cwd . "/front_end/vue/js",
            self::$installPath . 'resources/assets/js'
        );
    }

    private static function copyDir($source, $dest)
    {
        if (!file_exists($dest)) {
            mkdir($dest);
        }
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $sourceTemp = $source . '/' . $item;
            $destTemp = $dest . '/' . $item;
            if (is_file($sourceTemp)) {
                copy($sourceTemp, $destTemp);
            }
            if (is_dir($sourceTemp)) {
                self::copyDir($sourceTemp, $destTemp);
            }
        }
        closedir($handle);
    }
}
