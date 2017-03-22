<?php
/**
 * Created by PhpStorm.
 * User: viktoras
 * Date: 17.3.19
 * Time: 11.26
 */

namespace AppBundle\Service;


class TokenGenerator
{
   public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}