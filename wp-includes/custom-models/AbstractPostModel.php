<?php

namespace WordPress\CustomModels;

/**
 * @property-read $ID
 */
abstract class AbstractPostModel implements ModelInterface {
    protected \WP_Post $post;

    public static function getType() {
        return 'post';
    }

    public function __get($key) {
        if ($this->post->$key) {
            return $this->post->$key;
        }

        $func = 'get' . ucfirst($key);
        if (method_exists($this, $func)) {
            return call_user_func(array($this, $func));
        }

        return $key;
    }

    protected function getID() {
        return $this->post->ID;
    }

    public function __call(string $name, array $arguments) {
        if (method_exists($this->post, $name)) {
            return $this->post->$name(...$arguments);
        }
    }
}
