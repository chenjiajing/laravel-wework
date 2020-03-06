<?php


namespace ChenJiaJing\WeWork;


class BaseWeWork
{
    public $config;

    public $access_token = '';

    public function __construct($options)
    {
        if (empty($options['corpid'])) {

        }

        if (empty($options['corpsecret'])) {

        }
    }

    public function getAccessToken(){

    }

}
