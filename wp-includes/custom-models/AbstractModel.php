<?php

namespace WordPress\CustomModels;

abstract class AbstractModel implements ModelInterface {
    private static array $instances = array();

    /**
     * Each abstract Model have this function to have a cache of all instances
     *
     * @param $post
     *
     * @return mixed
     */
    protected static function getFromInstances(object $wordpressObject) {
        // Can disable instance cache with defined constant
        if (defined('CACHE_MODEL_INSTANCE') && CACHE_MODEL_INSTANCE === false) {
            return null;
        }

        $key = self::getInstanceKey(static::getObjectIDForKey($wordpressObject));
        if (array_key_exists($key, self::$instances)) {
            return self::$instances[$key];
        }
        return null;
    }

    /**
     * Get the object ID for the key of array instances
     *
     * @param object $wordPressObject
     *
     * @return int
     */
    abstract protected static function getObjectIDForKey(object $wordPressObject): int;

    /**
     * This function verify if the instance is currently in cache or create it and return it
     *
     * @param object $wordpressObject
     *
     */
    public static function createOrGetInstance(object $wordpressObject) {
        $instance = self::getFromInstances($wordpressObject);
        if ($instance === null) {
            $instance = new static($wordpressObject);
            self::setInstance(self::getInstanceKey(static::getObjectIDForKey($wordpressObject)), $instance);
        }
        return $instance;
    }

    protected static function getInstanceKey(int $id): string {
        return static::class . '_' . $id;
    }

    protected static function setInstance(string $key, object $instance) {
        self::$instances[$key] = $instance;
    }
}
