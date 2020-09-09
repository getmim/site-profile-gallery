<?php

return [
    '__name' => 'site-profile-gallery',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-profile-gallery.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-profile-gallery' => ['install','remove'],
        'modules/site-profile-gallery' => ['install','update','remove'],
        'theme/site/profile/gallery' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'site-profile' => NULL
            ],
            [
                'profile-gallery' => NULL
            ],
            [
                'site-meta' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'SiteProfileGallery\\Controller' => [
                'type' => 'file',
                'base' => 'app/site-profile-gallery/controller'
            ],
            'SiteProfileGallery\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile-gallery/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileGallery' => [
                'path' => [
                    'value' => '/profile/(:profile)/gallery/(:id)',
                    'params' => [
                        'profile' => 'slug',
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteProfileGallery\\Controller\\Gallery::single'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'profile-gallery' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteProfileGallery',
                        'params' => [
                            'profile' => '$profile.name',
                            'id' => '$id'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteProfileGallery\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SiteProfileGallery\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];