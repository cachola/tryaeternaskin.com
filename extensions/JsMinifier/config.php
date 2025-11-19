<?php

return array(
    'hooks'           => array(
        array(
            'event'    => 'beforeRenderScripts',
            'callback' => "Extension\JsMinifier\Compiler@updateResource",
            'priority' => 100,
        ),
    ),
    'routes'          => array(
        array(
            'slug'     => 'execute',
            'callback' => "Extension\JsMinifier\Compiler@execute",
        ),
    ),
    'actions'         => array(
        'activate'   => "Extension\JsMinifier\Compiler@execute",
        'deactivate' => "",
    ),
    'options'         => array(
        array(
            'label'   => 'Recompile',
            'handler' => 'execute',
        ),
    ),
    'quick_launchers' => array(
        array(
            'label'   => 'Purge Minified and compressed Javascript',
            'icon'    => 'cached',
            'handler' => 'execute',
        ),
    ),
    'settings'        => array(
        array(
            'label'    => 'Custom Script Links',
            'key'      => 'custom_scripts',
            'type'     => 'string',
            'textarea' => 'true',
            'value'    => '',
            'optional' => true,
            'hint'     => 'Add your custom JS file links separated by new line',
            'flex'     => 100,
        ),
    ),
);
