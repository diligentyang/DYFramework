<?php
namespace lib;

use systems\DYBaseFunc as DYBaseFunc;

defined('ACCESS') OR exit('No direct script access allowed');

class Password
{
    private $passwordHashCost = 13;
    //生成哈希密码
    public function generatePasswordHash($password, $cost = null)
    {
        if($cost === null){
            $cost = $this->passwordHashCost;
        }
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
        }

        $salt = $this->generateSalt($cost);
        $hash = crypt($password, $salt);
        if (!is_string($hash) || strlen($hash) !== 60) {
            DYBaseFunc::showErrors('Unknown error occurred while generating hash.');
        }

        return $hash;
    }

    private function generateSalt($cost)
    {
        $cost = (int)$cost;
        if ($cost < 4 || $cost > 31) {
            DYBaseFunc::showErrors('Cost must be between 4 and 31.');
        }
        // Get a 20-byte random string
        $rand = $this->generateRandomKey(20);
        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf("$2y$%02d$", $cost);
        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }

    private function generateRandomKey($length)
    {
        if (!is_int($length)) {
            DYBaseFunc::showErrors('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            DYBaseFunc::showErrors('First parameter ($length) must be greater than 0');
        }

        // always use random_bytes() if it is available
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        }
        if (function_exists('mcrypt_create_iv')) {
            $key = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if (mb_strlen($key, '8bit') === $length) {
                return $key;
            }
        }
        DYBaseFunc::showErrors("Unable to generateRandomKey!");
    }

    //check 哈希密码
    public function validatePassword($password, $hash)
    {
        if (!is_string($password) || $password === '') {
            DYBaseFunc::showErrors('Password must be a string and cannot be empty.');
        }
        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            DYBaseFunc::showErrors('Hash is invalid.');
        }

        if (function_exists("password_verify")) {
            return password_verify($password, $hash);
        }

        $test = crypt($password, $hash); //将用户输入的密码和哈希密码进行crypt()加密
        $n = strlen($test);//获取字节长度
        if ($n !== 60) {
            return false;
        }

        return $this->compareString($test, $hash);//compareString慢比较，两个密码，并返回Boolean类型
    }

    //慢比较
    private function compareString($test, $hash)
    {
        $testLen = mb_strlen($test, '8bit');
        $hashLen = mb_strlen($hash, '8bit');
        $diff = $testLen ^ $hashLen;
        for ($i = 0; $i < $testLen && $i < $hashLen; $i++) {
            $diff |= $test[$i] ^ $hash[$i];
        }
        return $diff === 0;
    }
}