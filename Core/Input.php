<?php

namespace Core;

/**
 * Input
 */
class Input {

    /**
     * $_POST data gets stored when self::lap called with $_POST
     * @var array
     */
    private static $posted = [];

    /**
     * Use this to start it all off. Input::lap($_POST);
     * @param  array  $postData $_POST var
     * @return null
     */
    public static function lap($postData=null) {
        self::$posted = $postData;
    }

    /**
     * Escape ', ", x00 with \
     * @param  string $str String to clean
     * @return string      Clean String
     */
    public static function _clean($str){
        return addslashes($str);
    }

    /**
     * Returns all posted items as an array with the option to htmlentities
     * @param  boolean $clean Use htmlentities or not
     * @return array          of $_POSTED inputs
     */
    public static function all($clean=true) {
        if($clean){
            foreach(self::$posted as $key => $value) {
                if(is_array($value)) {
                    foreach($value as $key2 => $value2) {
                        $postedData[$key][$key2] = self::_clean($value2);
                    }
                } else {
                    $postedData[$key] = self::_clean($value);
                }
            }
        } else {
            $postedData = self::$posted;
        }

        return $postedData;
    }

    /**
     * Return certain input name
     * Input::get("username", "Guest", true);
     * @param  string  $name    input field name, e.i: username
     * @param  string  $default Return this if no value from above
     * @param  boolean $clean   use htmlentities or not
     * @return string           input's value either clean or raw
     */
    public static function get($name, $default=null, $clean=true) {
        if(array_key_exists($name, self::$posted)){
            if(strpos($name, '.') !== false) {
                $seaching = explode(".", $name);
                $getTheVal = self::$posted[$seaching[0]][$seaching[1]];
            } else {
                $getTheVal = self::$posted[$name];
            }

            if($clean){
                $getTheVal = self::_clean($getTheVal);
            } else {
                $getTheVal = $getTheVal;
            }

            if(empty($getTheVal)){
                $getTheVal = $default;
            } else {
                $getTheVal = $getTheVal;
            }
        } else {
            $getTheVal = $default;
        }
        return $getTheVal;
    }

    /**
     * Check if certain input name is in here
     * @param  string  $name    input fields name (name="XX")
     * @param  boolean $showVal Show value on return if true
     * @return boolean          true/false if self::$posted has $name and if $showVal, show value too
     */
    public static function has($name, $showVal=false) {
        if(array_key_exists($name, self::$posted)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Resets/clears all posted data
     * @return null
     */
    public static function clear() {
        self::$posted = [];
        return;
    }
}
Input::lap($_POST);