<?php

namespace WordPress\CustomModels;

interface ModelInterface {
    /**
     * To know what type the model is (post type, taxonomy...)
     * @return string
     */
    public static function getType();
}
