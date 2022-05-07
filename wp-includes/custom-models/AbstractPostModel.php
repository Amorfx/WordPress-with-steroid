<?php

namespace WordPress\CustomModels;

/**
 * @property-read $ID
 */
abstract class AbstractPostModel extends AbstractModel {
    public \WP_Post $post;

    public static function getType() {
        return 'post';
    }

    public function __construct(\WP_Post $post) {
        $this->post = $post;
    }

    public function __isset($name) {
        if (isset($this->post->$name)) {
            return true;
        }

        return $this->post->__isset($name);
    }

    /**
     * Convert object to array.
     *
     * @since 3.5.0
     *
     * @return array Object as array.
     */
    public function to_array() {
        $post = get_object_vars( $this->post );

        foreach ( array( 'ancestors', 'page_template', 'post_category', 'tags_input' ) as $key ) {
            if ( $this->__isset( $key ) ) {
                $post[ $key ] = $this->__get( $key );
            }
        }

        return $post;
    }

    public function __get($key) {
        $func = 'get' . ucfirst($key);
        if (method_exists($this, $func)) {
            return call_user_func(array($this, $func));
        }

        if (isset($this->post->$key)) {
            return $this->post->$key;
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
