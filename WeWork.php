<?php


/**
 * 加载缓存器
 */
class WeWork
{
    /**
     * 定义当前版本
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * 静态配置
     * @var \ChenJiaJing\WeWork\Tools\ArrayTools
     */
    private static $config;

    /**
     * 设置及获取参数
     * @param array $option
     * @return array
     */
    public static function config($option = null)
    {
        if (is_array($option)) {
            self::$config = new \ChenJiaJing\WeWork\Tools\ArrayTools($option);
        }
        if (self::$config instanceof \ChenJiaJing\WeWork\Tools\ArrayTools) {
            return self::$config->get();
        }
        return [];
    }

    /**
     * 静态魔术加载方法
     * @param string $name 静态类名
     * @param array $arguments 参数集合
     * @return mixed
     * @throws \WeWork\Exceptions\InvalidInstanceException
     */
    public static function __callStatic($name, $arguments)
    {
        if (substr($name, 0, 6) === 'WeWork') {
            $class = 'WeWork\\' . substr($name, 6);
        }
        if (!empty($class) && class_exists($class)) {
            $option = array_shift($arguments);
            $config = is_array($option) ? $option : self::$config->get();
            return new $class($config);
        }
        throw new \WeWork\Exceptions\InvalidInstanceException("class {$name} not found");
    }

}