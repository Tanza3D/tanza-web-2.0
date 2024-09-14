<?php
namespace Database {
    use Memcached;

    class Memcache
    {
        private static $db;
        private $connection;

        public function __construct()
        {
            $this->connection = new Memcached();
            $this->connection->addServer("127.0.0.1", 11211) or die("Could not connect");
        }

        public static function getConnection()
        {
            if (self::$db == null) {
                self::$db = new Memcache();
            }
            return self::$db->connection;
        }

        public static function get($key) {
            return self::getConnection()->get("tanzaweb" . $key);
        }
        public static function set($key, $value, $expiration = 0) {
            return self::getConnection()->set("tanzaweb" . $key, $value, $expiration);
        }
    }
}