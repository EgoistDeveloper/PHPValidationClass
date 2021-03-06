<?php
/**
 * Extented Validation Class
 * Supports PHP 5 >= 5.1.0 && PHP 7.x.x
 *
 * 
 * MIT License
 * 
 * Copyright (c) 2018 EgoistDeveloper
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of 
 * this software and associated documentation files (the "Software"), to deal in 
 * the Software without restriction, including without limitation the rights to use, 
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH 
 * THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @category   Validation
 * @package    PHPValidationClass
 * @author     Original Author <hiam@egoist.dev>
 * @copyright  2018 EgoistDeveloper
 * @license    MIT
 * @version    0.5
 * @link       https://github.com/EgoistDeveloper/PHPValidationClass
 */

class Validate
{
    public $lang = null;
    public $errors = [];
    public $data = [];
    public $key = null;
    public $value = null;
    public $require = true;

    public $dataExists = true;
    public $keyExists = true;

    public $patterns = [
        'url' => '/^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/',
        'username' => '/^[0-9A-Za-z]{4, 30}$/',
        'password' => '/^((?=.{2,}[A-Z])(?=.{2,}[a-z])(?=.{2,}[0-9])(?=.{2,}[\w\s])).{6,128}$/',
        'date_dmy' => '/^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}$/',
        'date_ymd' => '/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/',
        'date_dmy_slash' => '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/',
        'date_ymd_slash' => '/^[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2}$/',
        'time_hi' => '/^[0-9]{2}:[0-9]{2}$/',
        'time_his' => '/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/',
        'rgba' => '/^((\d{1,3}), ?)((\d{1,3}), ?)(\d{1,3}),? ?(\d{1,3}),? ?$/',
        'rgb' => '/^((\d{1,3}), ?)((\d{1,3}), ?)(\d{1,3})$/',
        'hex_color' => '/^#?([a-fA-F-0-9]{1,2})([a-fA-F-0-9]{1,2})([a-fA-F-0-9]{1,2})([a-fA-F-0-9]{1,2})?$/',
        'domain' => '/^(?!:\/\/)([a-zA-Z0-9-_]+\.)*[a-zA-Z0-9][a-zA-Z0-9-_]+\.[a-zA-Z]{2,11}?$/'
    ];

    /**
     * Returns emojis character lenght
     * @param $emojiarray_push($this->errors, "{$this->lang->}")s
     * @return int
     */
    public function emojisLen($emojis)
    {
        return count(preg_split('~\X{1}\K~u', $emojis)) - 1;

        return $this;
    }

    /**
     * Email validation with native function
     *
     * @param string $email users' email address
     * @param bool $return: direct return
     * @return bool
     */
    public function isEmail($email = null, $return = false)
    {
        if ($return){
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        } else if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, "{$this->lang->validate_invalid_email_address}: {$this->value}");
        }

        return $this;
    }

    /**
     * Username validation
     *
     * @param string $username: selected username
     * @param bool $return: direct return
     * @return bool
     */
    public function isUsername($username = null, $return = false)
    {
        if ($return){
            return preg_match($this->patterns['username'], $username);
        } else if ($this->value && !preg_match($this->patterns['username'], $this->value)){
            array_push($this->errors, "{$this->lang->validate_invalid_username}: {$this->value}");
        }

        return $this;
    }

    /**
     * User password validation
     *
     * @param string $password selected password
     * @param bool $return: direct return
     * @return bool
     */
    public function isPassword($password = null, $return = false)
    {
        if ($return){
            return preg_match($this->patterns['password'], $password);
        } else if ($this->value && !preg_match($this->patterns['password'], $this->value)){
            array_push($this->errors, "{$this->lang->validate_invalid_password}: {$this->value}");
        }

        return $this;
    }

    /**
     * URL adress validation
     * 
     * @param string $url URL address
     * @param string $urlPattern: custom pattern
     * @return bool
     */
    public function isUrl($pattern = null, $native = false, $return = false)
    {
        if ($return) {
            if ($pattern && $this->value && preg_match($pattern, $this->value)) {
                return array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
            } else if ($native === false && $this->value && !preg_match($this->patterns['url'], $this->value)) {
                return array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
            } else if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
                return array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
            }
        }

        if ($pattern && $this->value && preg_match($pattern, $this->value)) {
            array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
        } else if ($native === false && $this->value && !preg_match($this->patterns['url'], $this->value)) {
            array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
        } else if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            array_push($this->errors, "{$this->lang->validate_invalid_url} {$this->key}");
        }

        return $this;
    }

    /**
     * JSON object validation
     * 
     * @param stdClass $object
     * @return bool
     */
    public function isJsonObject($object)
    {
        if ($object === null) {
            return false;
        }

        return $object instanceof stdClass;
    }

    /**
     * JSON string validation
     *
     * @param string $json
     * @return bool
     */
    public function isJson($json)
    {
        if (!is_string($json)) {
            return false;
        }

        json_decode($json);

        if ($this->value && json_last_error() != JSON_ERROR_NONE) {
            array_push($this->errors, "{$this->lang->validate_invalid_json_string} {$this->key}");
        }

        return $this;
    }

    /**
     * HEX color validation
     * 
     * @param string|int $color
     * @return bool
     */
    public function isHexColor($color = null, $return = false)
    {
        if ($return){
            return preg_match($this->patterns['hex_color'], $color);
        } else if($this->value && !preg_match($this->patterns['hex_color'], $this->value)) {
            array_push($this->errors, "{$this->lang->validate_invalid_hex_color} {$this->key}");
        }

        return $this;
    }

    /**
     * RGB color validation
     * 
     * @param string|int $color
     * @return bool
     */
    public function isRgbColor($color = null, $return = false)
    {
        if ($return){
            return preg_match($this->patterns['rgb'], $color);
        } else if($this->value && !preg_match($this->patterns['rgb'], $this->value)) {
            array_push($this->errors, "{$this->lang->validate_invalid_rgb_color} {$this->key}");
        }

        return $this;
    }

    /**
     * RGBA color validation
     * 
     * @param string|int $color
     * @return bool
     */
    public function isRgbaColor($color = null, $return = false)
    {
        if ($return){
            return preg_match($this->patterns['rgba'], $color);
        } else if ($this->value && !preg_match($this->patterns['rgba'], $this->value)){
            array_push($this->errors, "{$this->lang->validate_invalid_rgba_color} {$this->key}");
        }

        return $this;
    }

    /******************************* DATE / TIME START ***********************************/

    /**
     * Checks date is dd-mm-yyyy format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isDateDmy(string $date = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['date_dmy'], $date);
        } else {
            if ($this->value && !preg_match($this->patterns['date_dmy'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_dmy_value} {$this->value}");
            }
        }

        return $this;
    }

    /**
     * Checks date is yyyy-mm-dd format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isDateYmd(string $date = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['date_ymd'], $date);
        } else {
            if ($this->value && !preg_match($this->patterns['date_ymd'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_ymd_value} {$this->value}");
            }
        }

        return $this;
    }

    /**
     * Checks date is dd-mm-yyyy format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isDateDmyWithSlash(string $date = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['date_dmy_slash'], $date);
        } else {
            if ($this->value && !preg_match($this->patterns['date_dmy_slash'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_dmy_value} {$this->value}");
            }
        }

        return $this;
    }

    /**
     * Checks date is yyyy-mm-dd format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isDateYmdWidthSlash(string $date = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['date_ymd_slash'], $date);
        } else {
            if ($this->value && !preg_match($this->patterns['date_ymd_slash'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_ymd_value} {$this->value}");
            }
        }

        return $this;
    }

    /**
     * Checks date is yyyy-mm-dd format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isTimeHi(string $time = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['time_hi'], $time);
        } else {
            if ($this->value && !preg_match($this->patterns['time_hi'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_ymd_value} {$this->value}");
            }
        }

        return $this;
    }

    /**
     * Checks date is yyyy-mm-dd format
     * 
     * @param string $date: date as string
     * @return $this
     */
    public function isTimeHis(string $time = null, $return = false)
    {
        if ($return) {
            return preg_match($this->patterns['time_his'], $time);
        } else {
            if ($this->value && !preg_match($this->patterns['time_his'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_date_ymd_value} {$this->value}");
            }
        }

        return $this;
    }

    /******************************* DATE / TIME END ***********************************/

    /**
     * Checks is domain
     */
    public function isDomain($return = false)
    {
        if ($return) {
            if ($this->value && !preg_match($this->patterns['domain'], $this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_domain} ({$this->key})");
            }

            return false;
        }

        if ($this->value && !preg_match($this->patterns['domain'], $this->value)) {
            array_push($this->errors, "{$this->lang->validate_invalid_domain} {$this->key}");
        }

        return $this;
    }

    /**
     * Checks is null the value
     * @return $this
     */
    public function isNull()
    {
        if (!is_numeric($this->value) && !is_bool($this->value)){
            if ($this->keyExists && empty($this->value)) {
                array_push($this->errors, "{$this->lang->validate_field_is_null} {$this->key}");
            }
        }

        return $this;
    }

    /**
     * Type is check
     * 
     * @param string $type: required value type
     * @return $this
     */
    public function typeIs(string $type, $return = false)
    {
        if ($return) {
            if ($this->keyExists && $this->value) {
                if ($type != 'numeric' && gettype($this->value) != $type) {
                    return false;
                } else if ($type == 'numeric' && !is_numeric($this->value)) {
                    return false;
                }
            }

            return false;
        }

        if ($this->keyExists && $this->value) {
            if ($type != 'numeric' && gettype($this->value) != $type) {
                array_push($this->errors, "{$this->lang->validate_invalid_value_type} {$type} ({$this->key})");
            } else if ($type == 'numeric' && !is_numeric($this->value)) {
                array_push($this->errors, "{$this->lang->validate_invalid_value_type_numeric} ({$this->key})");
            }
        }

        return $this;
    }

    /**
     * Checks atleast length string, int and arrays
     * 
     * @param int $min: minimum length
     * @param int $max: maximum length
     * @return $this
     */
    public function length(int $min, int $max)
    {
        if ($this->keyExists) {
            $length = null;

            if ($this->value && is_string($this->value)) {
                $length = strlen($this->value);
            } else if ($this->value && is_numeric($this->value)) {
                $length = (int)$this->value;
            } else if ($this->value && is_array($this->value)) {
                $length = count($this->value);
            }

            if ($length && ($length < $min || $length > $max)) {
                array_push($this->errors, "{$this->lang->validate_invalid_value_length} {$min} > && < {$max} ({$this->key})");
            }
        }

        return $this;
    }

    /**
     * Checks value is in array
     * 
     * @param array $array: excepted values
     * @return $this
     */
    public function valueIn(array $array)
    {
        if ($this->keyExists && $this->value && !in_array($this->value, $array)) {
            $exceptedValues = implode(', ', array_slice($array, 0, 9)) . (count($array) > 10 ? '...' : null);

            array_push($this->errors, "{$this->lang->validate_unexpected_value} {$exceptedValues} ({$this->key})");
        }

        return $this;
    }

    /**
     * Required key in data array
     * 
     * @param array $data: data block
     * @param string $key: required key
     * @return $this
     */
    public function require(string $key)
    {
        $this->require = true;
        $this->key = isset($this->lang->$key) ? $this->lang->$key : $key;

        if (empty($this->data) || is_null($this->data)) {
            $this->dataExists = false;
            array_push($this->errors, "{$this->lang->validate_mising_arguments}");
        } else if (!array_key_exists($key, $this->data)) {
            $this->keyExists = false;
            array_push($this->errors, "{$this->lang->validate_argument_missing} {$this->key}");
        } else {
            $this->value = $this->data[$key];
        }

        return $this;
    }

    /**
     * Not required but if exists will be check
     * 
     * @param array $data: data block
     * @param string $key: required key
     * @return $this
     */
    public function notRequire(string $key)
    {
        $this->require = false;
        $this->key = isset($this->lang->$key) ? $this->lang->$key : $key;

        if (empty($this->data) || is_null($this->data)) {
            $this->dataExists = false;
            array_push($this->errors, "{$this->lang->validate_mising_arguments}");
        } else if (!array_key_exists($key, $this->data)) {
            $this->keyExists = false;
        } else {
            $this->value = $this->data[$key];
        }

        return $this;
    }

    /**
     * Set single value for single validations
     * 
     * @param mixed $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Clear some data for next checks
     */
    public function check()
    {
        $this->key = null;
        $this->value = null;
        $this->require = true;
        $this->keyExists = true;
    }

    public function isSuccess()
    {
        return !count($this->errors);
    }
}