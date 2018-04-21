<?php

namespace Core;

use App\Config;

/**
 * Database
 */
class Database {
    private static $dbConnection;
    public static $num_queries = 0;
    public static $cache_time = 4 * 3600;
    
    public static function _init() {
        if(self::$dbConnection != null) {
            return;
        }

        $connection = mysqli_connect(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME, Config::DB_PORT);
        if(!$connection) {
            throw new \Exception("Coudln't connect to database. ENO: ".mysqli_connect_errno()." ER: ".mysqli_connect_error()."");
        }
        $connection->set_charset("utf8mb4");
        self::$dbConnection = $connection;
    }

    public static function secure($string) {
        return mysqli_real_escape_string(self::$dbConnection, $string);
    }

    public static function lastId() {
        return mysqli_insert_id(self::$dbConnection);
    }

    public static function rowCount($qCommand) {
        $cache_file = "../public/storage/cache/mysql/".md5($qCommand).".cache";
        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - self::$cache_time))) {
            $queryC = unserialize(file_get_contents($cache_file));
        } else {
            file_put_contents($cache_file, serialize(self::query($qCommand)->num_rows), LOCK_EX);
            $queryC = self::query($qCommand)->num_rows;
        }
        return $queryC;
    }

    public static function getResult($qCommand, $qColumn) {
        $cache_file = "../public/storage/cache/mysql/".md5($qCommand).md5($qColumn).".cache";
        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - self::$cache_time))) {
            $queryC = unserialize(file_get_contents($cache_file));
        } else {
            file_put_contents($cache_file, serialize(self::query($qCommand)->fetch_assoc()[$qColumn]), LOCK_EX);
            $queryC = self::query($qCommand)->fetch_assoc()[$qColumn];
        }
        return $queryC;
    }

    public static function getArray($qCommand, $type=MYSQLI_ASSOC, $toCache=true) {
        if($toCache){
            $cache_file = "../public/storage/cache/mysql/".md5($qCommand).md5($type).".cache";
            if (file_exists($cache_file) && (filemtime($cache_file) > (time() - self::$cache_time))) {
                $queryC = unserialize(file_get_contents($cache_file));
            } else {
                file_put_contents($cache_file, serialize(self::query($qCommand)->fetch_array($type)), LOCK_EX);
                $queryC = self::query($qCommand)->fetch_array($type);
            }
        } else {
            $queryC = self::query($qCommand)->fetch_array($type);
        }
        return $queryC;
    }

    public static function getAll($qCommand, $type=MYSQLI_ASSOC, $toCache=true, $cacheTime = 4 * 3600, $forceReloadCache = false) {
        $checkQuery = self::query($qCommand);
        if ($checkQuery !== FALSE) {
            if($toCache){
                $cache_file = "../public/storage/cache/mysql/".md5($qCommand).md5($type).".cache";
                if($forceReloadCache) {
                    if (file_exists($cache_file)) {
                        unlink($cache_file);
                    }
                    $queryC = self::query($qCommand)->fetch_all($type);
                } else {
                    if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $cacheTime))) {
                        $queryC = unserialize(file_get_contents($cache_file));
                    } else {
                        file_put_contents($cache_file, serialize(self::query($qCommand)->fetch_all($type)), LOCK_EX);
                        $queryC = self::query($qCommand)->fetch_all($type);
                    }
                }
            } else {
                $queryC = self::query($qCommand)->fetch_all($type);
            }
            return $queryC;
        } else {
            return null;
        }
    }

    public static function numRows($qCommand, $toCache=false) {
        if($toCache){
            $cache_file = "../public/storage/cache/mysql/".md5($qCommand).".cache";
            if (file_exists($cache_file) && (filemtime($cache_file) > (time() - self::$cache_time))) {
                $queryC = unserialize(file_get_contents($cache_file));
            } else {
                file_put_contents($cache_file, serialize(self::query($qCommand)->num_rows), LOCK_EX);
                $queryC = self::query($qCommand)->num_rows;
            }
        } else {
            $queryC = self::query($qCommand)->num_rows;
        }
        return $queryC;
    }

    public static function query($qCommand) {
        $query = self::$dbConnection->query($qCommand);
        self::$num_queries++;
        return $query;
    }

    public static function getError() {
        return self::$dbConnection->error;  
    }

    public static function _kill(){
        self::$num_queries = 0;
        return mysqli_close(self::$dbConnection);
    }

    public static function getTotalQueries(){
        return self::$num_queries;
    }
}
Database::_init();