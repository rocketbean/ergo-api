<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Driver Default
    |--------------------------------------------------------------------------
    |
    | booting up environments to use
    | can be added by adding an array of data,
    | pointing to the endpoints and setting up the default
    | to use
    | default setup: (local, dev); 
    |
    */

  'default' => [
    'driver' => 'local'
  ],


    /*
    |--------------------------------------------------------------------------
    | Driver 
    |--------------------------------------------------------------------------
    |
    | STATUS ******
    | [configurable] allows to access routes like creating the first user and configure the system core
    | [fixed] disables the configuring routes for the api
    |
    */

  'driver' => [
    'local' => [
      'status'    => 'configurable',
      'auth_url'  => 'http://localhost/',
      'userkey'   => '_key'
    ],
    'dev' => [
      'status'    => 'configurable',
      'auth_url'  => 'http://localhost/',
      'userkey'   => '_key'
    ],
    'prod' => [
      'status' => 'configurable',
      'auth_url' => 'http://localhost/',
      'userkey'   => '_key'
    ]
  ],


  'firstusers' => [
    [
      'name'      => 'Nikko Mesina',
      'role_id'   => 1,
      'email'     => 'nikko@homeprezzo.com',
      'password'  => '$2y$12$9G3p50NJPGGN9nOGz/mWfuuFNqXo35azSXACRhDcQ2ctv2BuovHq2' // qweqwe
    ],
    [
      'name'      => 'N mesina',
      'role_id'   => 2,
      'email'     => 'buzzokkin@gmail.com',
      'password'  => '$2y$12$9G3p50NJPGGN9nOGz/mWfuuFNqXo35azSXACRhDcQ2ctv2BuovHq2' // qweqwe
    ]

  ],

  'objects' => [
    'properties' => [ 
      [
        'name'        => 'Suspendisse pulvinar augue',
        'user_id'     => 1,
        'primary'     => 1,
        'description' => 'Nam at tortor in tellus interdum sagittis. Nulla neque dolor, sagittis eget, iaculis quis, molestie non, velit. Quisque ut nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed aliquam, nisi quis porttitor congue, elit erat euismod orci, ac placerat dolor lectus quis orci. Vivamus laoreet. Duis vel nibh at velit scelerisque suscipit. Vivamus laoreet. Sed aliquam ultrices mauris. Nunc sed turpis. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.'
      ]
    ],
    'suppliers' => [
      [
        'name'        => 'Phasellus a est',
        'user_id'     => 2,
        'primary'     => 1,
        'description' => 'Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Vivamus aliquet elit ac nisl. Morbi vestibulum volutpat enim. Nulla consequat massa quis enim. Praesent porttitor, nulla vitae posuere iaculis, arcu nisl dignissim dolor, a pretium mi sem ut ipsum. Nulla sit amet est. Fusce egestas elit eget lorem. Quisque rutrum. Praesent nonummy mi in odio. Suspendisse feugiat.'
      ]
    ]
  ]
];
