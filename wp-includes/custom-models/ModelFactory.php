<?php

namespace WordPress\CustomModels;


class ModelFactory {
    private static array $postModelRegistry = array();

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
}
