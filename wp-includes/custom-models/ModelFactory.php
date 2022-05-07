<?php

namespace WordPress\CustomModels;


class ModelFactory {
    private static array $postModelRegistry = array();

    /**
     * Main function to return a model from a WordPress class
     * @param object|null $currentObject
     *
     * @return null|mixed
     * @throws \Exception
     */
    public static function create(?object $currentObject) {
        if (is_null($currentObject) || is_wp_error($currentObject)) {
            return null;
        }

        switch (get_class($currentObject)) {
            case \WP_Post::class:
                $className = self::getPostModelClassName($currentObject->post_type);
                if ($className === false) {
                    return $currentObject;
                }
                $model = forward_static_call(array($className, 'createOrGetInstance'), $currentObject);
                break;
        }
        return $model;
    }

    /**
     * Add to registry all className of post that the factory can create
     * @param array $postModelsClassName
     */
    public static function registerPostModels(array $postModelsClassName): void {
        foreach ($postModelsClassName as $className) {
            // TODO better abstraction for getTypes not use static var anymore
            if (method_exists($className, 'getType')) {
                $type = $className::getType();
            } else {
                $type = $className::$type;
            }

            // Can have multiple post types for one model
            if (is_array($type)) {
                foreach ($type as $t) {
                    self::$postModelRegistry[$t] = $className;
                }
            } else {
                self::$postModelRegistry[$type] = $className;
            }
        }
    }

    /**
     * This function get the classname of model that associated with the post type
     * @param string $postType
     *
     * @return string|false
     * @throws \Exception
     */
    private static function getPostModelClassName(string $postType) {
        if (!array_key_exists($postType, self::$postModelRegistry)) {
            return false;
        }
        return self::$postModelRegistry[$postType];
    }
}
