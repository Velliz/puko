<?php

namespace Config;

class PresentationConfig
{
    /**
     * key '?' represent the value that will replaced by Puko with actual Data.
     */
    var $HTML_CONFIG = array(
        'value' => '{!?}',
        'condition' => array(
            'open' => '{!!?}',
            'close' => '{/?}',
        ),
        'loop' => array(
            'open' => '{!?}',
            'close' => '{/?}',
        ),
        'style' => '@css{?}',
        'url' => '@url{?}',
        'script' => '@js{?}',
    );

}
