<?php

return array(
	'hooks' => array(
		array(
			'event' => 'beforeBodyTagClose',
			'callback' => "Extension\GoogleAutoComplete\GoogleAutoComplete@googleLoadScripts",
			'priority' => 100
		),
	),
	'settings' => array(
		array(
			'label' => 'Google API Key',
			'key' => 'google_api_key',
			'type' => 'string',
			'value' => '',
			'hint'  => 'Enter multiple API keys in new lines.',
			'textarea' => true,
		),
		array(
			'label' => 'Event Type',
			'key' => 'event_type',
			'type' => 'enum',
			'value' => array('blur','keyup'),
		),
		array(
			'label' => 'Autopopulate By',
			'key' => 'autopopulate_by',
			'type' => 'enum',
			'value' => array('zip','address'),
		),
                array(
                        'label' => 'Disable Component Restriction',
                        'key'   => 'disable_component_restriction',
                        'type'  => 'boolean',
                        'value' => false,
                ),
	),
	'scripts' => array(
		'googleAutoload' => 'js/google-auto-complete.js'
	)
);
