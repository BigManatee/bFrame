<?php

namespace Core;

class Users {
	
	public static function pwdHash($pwd) {
        /**
         * todo: improve
         */
    	return sha1(md5(md5(md5(sha1(strrev(md5($pwd)))))));
	}
}