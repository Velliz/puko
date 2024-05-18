<?php

namespace controller;

use Parsedown;
use pukoframework\Framework;
use pukoframework\middleware\View;

/**
 * #Template master false
 * #Value title Hello World
 */
class docs extends View
{

    /**
     * @return array|void
     */
    public function apispecs()
    {
        if (Framework::$factory->getEnvironment() === 'DEV') {
            $changelog = sprintf("%s/assets/docs/apispecs.md", Framework::$factory->getRoot());
            if (!file_exists($changelog)) {
                die("apispecs.md file not found!");
            }
            $file = file_get_contents($changelog);

            $data['changelog'] = Parsedown::instance()->text($file);
            return $data;
        } else {
            return [];
        }
    }

    /**
     * @return array|void
     */
    public function changelog()
    {
        $changelog = sprintf("%s/assets/docs/changelog.md", Framework::$factory->getRoot());
        if (!file_exists($changelog)) {
            die("changelog.md file not found!");
        }
        $file = file_get_contents($changelog);

        $data['changelog'] = Parsedown::instance()->text($file);
        return $data;
    }

}