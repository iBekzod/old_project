<?php


namespace App\HelperClasses;


use App\Translation;

class Translations
{
    public $translations;

    private static $instance;

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Translations
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getTranslations()
    {
        static::getInstance()->translations = Translation::all();
    }

    public function search($lang, $lang_key)
    {
        $obj = self::getInstance();

        if (!$obj->translations) {
            $obj->getTranslations();
        }

        return self::getInstance()->translations->where('lang', $lang)->where('lang_key', $lang_key)->all();
    }
}
