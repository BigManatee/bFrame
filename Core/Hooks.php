<?php

namespace Core;

/**
 * Function / Action Hooks
 */
class Hooks {

	/**
	 * Include and "run" the selected file
	 * @param string $type  [before,after]
	 * @param string $event Event Name
	 */
    public static function Run($type, $event) {

    	/**
    	 * Check if $type is either before or after
    	 */
    	$calledFrom = debug_backtrace();
    	if(!in_array($type, ['before','after'])) {
    		throw new \Exception("Invalid \$type used ($type), needs to be 'before' or 'after' in ".$calledFrom[0]['file']." on line ".$calledFrom[0]['line']." ");
    	}

    	/**
    	 * Check if the hook exists and include it else throw error
    	 */
        if(file_exists(dirname(__DIR__)."/App/Hooks/".$type."_".$event.".php")){
        	require_once(dirname(__DIR__)."/App/Hooks/".$type."_".$event.".php");
        } else {
        	throw new \Exception("Hook file ".$type."_".$event.".php does not exist in /App/Hooks/");
        }
    }
}