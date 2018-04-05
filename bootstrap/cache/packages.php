<?php return array (
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'pusher/pusher-http-laravel' => 
  array (
    'providers' => 
    array (
      0 => 'Pusher\\Laravel\\PusherServiceProvider',
    ),
    'aliases' => 
    array (
      'Pusher' => 'Pusher\\Laravel\\Facades\\Pusher',
    ),
  ),
);