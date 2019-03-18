<?php

$config = array(
  'authMethod' => array(
    'type' => 'radios',
    'label' => 'Authorization Method',
    'description' => 'Which Authorization Method do you want to use?', 
    'options' => array(
      'none' => 'None', 
      'session' => 'Session',
      'basic' => 'Basic Auth',
      'jwt' => 'JWT', 
    ),
    'value' => 'none',
    'required' => true,
    'notes' => 'If you use Session/JWT, users have to authenticate by default to be able to use the API. Learn more: https://github.com/thomasaull/RestApi'
  ),

  'jwtSecret' => array(
    'type' => 'textarea',
    'label' => 'JWT secret',
    'description' => "JWT Secret (don't share!) to use for JWT Auth. If you change this, every client has to obtain a new JWT token in order to make API calls.",
    'notes' => 'IMPORTANT: You need to save this page at least once to make the secret permanent! (I found out the hard way…)',
    'required' => true, 
    'value' => base64_encode(openssl_random_pseudo_bytes(128)),
    'minlength' => 128,
    'showCount' => true
  ),

  'endpoint' => array(
    'type' => 'text',
    'label' => 'API Endpoint',
    'description' => "Endpoint under which your API should be available", 
    'pattern' => '[a-z0-9-/]+',
    'minlength' => 1,
    'required' => true, 
    'value' => 'api',
    'notes' => "('a-z', 0-9, '-' and '/' allowed, Default: 'api')\nFor subdirectories use e.g. subdir/api (no leading slash)"
  )
);