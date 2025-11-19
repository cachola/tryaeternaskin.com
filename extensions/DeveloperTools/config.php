<?php

return array(
    'hooks'  => array(),
    'routes' => array(
        array(
            'slug'     => 'patch',
            'callback' => 'Extension\DeveloperTools\DeveloperTools@runNightlyPatches'
        ),
        array(
            'slug'     => 'commit-pull',
            'callback' => 'Extension\DeveloperTools\Upstream@commitAndPull'
        ),
    ),
    'options' => array(
        array(
            'label'   => 'Update Framework',
            'handler' => 'commit-pull',
            'confirm' => 'Do you want to update the Framework?',
        ),
    ),
    'crons'   => array(
        array(
            'every'   => '0 22 * * *',
            'handler' => 'Extension\DeveloperTools\DeveloperTools@runNightlyPatches',
        ),
    )
);

