<?php
/**
 * Created by PhpStorm.
 * User: HIEUTRIEU
 * Date: 10/2/2015
 * Time: 3:03 PM
 */

namespace Framework\Lang;


/**
 * Class Config
 *
 * @package Framework
 */

class Lang
{
    private static $instance = null;
    private static $data;
    public $langDir = 'lang';
    private $lang = 'vi';
    private $folder = 'backend';

    public static function getInstance($folder = 'backend', $lang = 'vi')
    {
        if (self::$instance == null) {
            self::$instance = new Lang($folder, $lang);
        }
        return self::$instance;
    }

    /**
     * __construct
     *
     */
    public function __construct($folder, $lang)
    {
        $this->lang = $lang;
        $this->folder = $folder;
    }

    /**
     * Get Configuration
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key)
    {
        if (!self::has($key)) {
            return $key;
        }

        $key_array = preg_split('/\./', $key);
        $return = self::$data;

        foreach ($key_array as $k) $return = $return[$k];

        return $return;
    }

    public function has($key)
    {
        if (defined('__APP__')) {
            $basePath = __APP__;
        } else {
            $basePath = "";
        }

        $file_path = $basePath . '/' . $this->langDir . '/' . $this->folder . '/' . $this->lang . '.php';
        if (file_exists($file_path)){
            self::$data = include $file_path;
        } else {
            self::$data = null;
        }

        if (self::$data == false) {
            self::$data = null;
        }

        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }

        return false;
    }

    public function getLang() {
        return $this->lang;
    }
}