<?php

return array(
    'hooks'  => array(
        array(
            'event'    => 'beforeSplitOrderCrmRequest',
            'callback' => "Extension\\AsyncSplit\\AsyncSplit@captureCrmPayload",
            'priority' => 100,
        ),
        array(
            'event'    => 'beforeBodyTagClose',
            'callback' => "Extension\\AsyncSplit\\AsyncSplit@injectScript",
            'priority' => 100,
        ),
    ),
    'routes' => array(
        array(
            'slug'     => 'place-order',
            'callback' => "Extension\\AsyncSplit\\AsyncSplit@placeOrder",
        ),
    ),
    'settings' => array(
        array(
            'label' => 'Enable Native Datacapture',
            'key'   => 'enable_native_datacapture',
            'type'  => 'boolean',
            'value' => false            
        ),
        array(
            'label' => 'Native Datacapture Table',
            'key'   => 'native_datacapture_table',
            'type'  => 'string',
            'value' => '',
            'optional' => true
        ),
    ),
);
