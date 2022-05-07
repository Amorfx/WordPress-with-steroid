<?php

use WordPress\CustomModels\ModelFactory;
use WordPress\CustomModels\PostModel;

require __DIR__ . '/ModelFactory.php';
require __DIR__ . '/ModelInterface.php';
require __DIR__ . '/AbstractModel.php';
require __DIR__ . '/AbstractPostModel.php';
require __DIR__ . '/PostModel.php';

// Register default custom models
function wp_register_custom_models() {
    if (!apply_filters('enabled_register_default_custom_models', true)) {
        return;
    }

    ModelFactory::registerPostModels(array(PostModel::class));
}
