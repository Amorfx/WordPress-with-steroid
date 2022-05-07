<?php

namespace WordPress\CustomModels;

class PostModel extends AbstractPostModel {
    protected static function getObjectIDForKey(object $wordPressObject): int {
        return $wordPressObject->ID;
    }

    protected function getPost_title() {
        return 'ok'; // just an example
    }
}
