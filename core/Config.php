<?php 

namespace Core;

class Config {
    private static $config = [
        'version'             =>  '0.0.1',
        'root_dir'            => '/cms/',  //  This will likely be / on a live server
        'default_controller'  => 'Curso',  // The default home controller
        'default_layout'      => 'default', // Default layout that is used
        'default_site_title'  => 'Cursoalimentos', // Default Site title
        'db_host'             => '127.0.0.1', // DB host please use IP address not domain
        'db_name'             => 'cms_template', // DB name
        'db_user'             => 'root', // DB user
        'db_password'         => '', // DB password
        'login_cookie_name'   => 'aisdjijaem2458ad' // Login cookie name
    ];

    public static function get($key) {
        return array_key_exists($key, self::$config)? self::$config[$key] : NULL;
    }
}