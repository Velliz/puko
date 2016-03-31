<?php
/**
 * key '?' represent the value that will replaced by Puko with actual Data.
 */
$viewConfig = array(
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
return $viewConfig;