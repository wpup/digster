<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digister
 * @license MIT
 * @version 1.0.0
 */

namespace Digster\Engines;

use Digster\Container;

/**
 * Engine.
 *
 * @package Digster
 * @since 1.0.0
 */

abstract class Engine extends Container
{
    /**
     * The any composer key that all template uses.
     *
     * @var string
     * @since 1.0.0
     */

    protected $anyComposerKey = 'any';

    /**
     * Engines composers.
     *
     * @var array
     * @since 1.0.0
     */

    protected $composers = array();

    /**
     * The default extension (empty string).
     *
     * @var string
     * @since 1.0.0
     */

    protected $extension = '';

    /**
     * The View instance.
     *
     * @var \Digster\Engine
     * @since 1.0.0
     */

    private static $instance = null;

    /**
     * The config locations key.
     *
     * @var string
     * @since 1.0.0
     */

    protected $locationsKey = 'locations';

    /**
     * Get or set configuration values.
     *
     * @param array|string $key
     * @param mixed $value
     * @since 1.0.0
     *
     * @return mixed
     */

    public function config($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $id => $val) {
                $this->config($id, $val);
            }
        } else {
            if (!is_null($value)) {
                return $this->bind($key, $value);
            }

            if ($this->exists($key)) {
                return $this->make($key);
            } else {
                $default = $this->getDefaultConfig();
                return isset($default[$key]) ? $default[$key] : null;
            }
        }
    }

    /**
     * Set twig extension if it don't exists on the template string.
     *
     * @param string $template
     * @since 1.0.0
     *
     * @return string
     */

    public function extension($template)
    {
        return substr($template, -strlen($this->extension)) === $this->extension
            ? $template : $template . $this->extension;
    }

    /**
     * Get the Engine instance.
     *
     * @since 1.0.0
     *
     * @return \Digster\Engine
     */

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Get composer by template.
     *
     * @param string $template
     * @since 1.0.0
     *
     * @return array
     */

    protected function getComposer($template)
    {
        if (is_array($template)) {
            $template = array_shift($template);
        }

        $composers = [];
        $template  = $this->extension($template);

        if (isset($this->composers[$template])) {
            $composers = array_merge($res, $this->composers[$template]);
        }

        if (isset($this->composers[$this->anyComposerKey])) {
            $composers = array_merge($res, $this->composers[$this->anyComposerKey]);
        }

        return $composers;
    }

    /**
     * Get default configuration.
     *
     * @since 1.0.0
     *
     * @return array
     */

    protected function getDefaultConfig()
    {
        $config = [];

        $config[$this->locationsKey] = [
            get_template_directory() . '/views'
        ];

        return $config;
    }

    /**
     * Get engine config.
     *
     * @since 1.0.0
     *
     * @return array
     */

    protected function getEngineConfig()
    {
        $config    = $this->prepareEngineConfig();
        $locations = $config[$this->locationsKey];

        unset($config[$this->locationsKey]);

        $locations = array_filter((array) $locations, function ($location) {
            return file_exists($location);
        });

        return [$locations, $config];
    }

    /**
     * Prepare template data with preprocesses.
     *
     * @param string $template
     * @param array $data
     * @since 1.0.0
     *
     * @return array
     */

    protected function prepareData($template, $data)
    {
        $data         = (array) $data;
        $preprocesses = $this->composer($template);

        foreach ($preprocesses as $fn) {
            $data = array_merge($data, $fn($data));
        }

        return $data;
    }

    /**
     * Render template with given data.
     *
     * @param string $template
     * @param array $data
     *
     * @since 1.0.0
     *
     * @return string
     */

    abstract public function render($template, $data);

    /**
     * Register extension.
     *
     * @since 1.0.0
     */

    abstract public function registerExtension();

    /**
     * Register preprocess with templates.
     *
     * @param array|string $template
     * @param callable $fn
     * @since 1.0.0
     */

    public function composer($template, $fn = null)
    {
        if (is_null($fn)) {
            return $this->getComposer($template);
        }

        $template = (array) $template;

        foreach ($template as $tmpl) {
            if ($tmpl !== $this->anyPreprocessKey) {
                $tmpl = $this->extension($tmpl);
            }

            if (!isset($this->preprocesses[$tmpl])) {
                $this->preprocesses[$tmpl] = array();
            }

            $this->preprocesses[$tmpl][] = $fn;
        }
    }

    /**
     * Prepare the template engines real configuration.
     *
     * @param array $arr
     * @since 1.0.0
     *
     * @return array
     */

    protected function prepareConfig($arr)
    {
        $result = [];

        if (!is_array($arr)) {
            return $result;
        }

        $arr = array_merge($this->getDefaultConfig(), $arr);

        foreach ($arr as $key => $value) {
            $res          = $this->config($key);
            $result[$key] = is_null($res) ? $value : $res;
        }

        return apply_filters('digster/config', $result);
    }

    /**
     * Register extension.
     *
     * @since 1.0.0
     */

    abstract public function prepareEngineConfig();
}
