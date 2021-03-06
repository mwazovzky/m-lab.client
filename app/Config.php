<?php

namespace App;

class Config
{
    use Singleton;

    /**
     * Configuration parameters.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create Environment  instance  singleton and
     * read configuration parameters from the file
     *
     * @param type name
     * @return type
     */
    protected function __construct($path = null)
    {
        $this->pathname = $path ?: __DIR__ . '/../config/';

        foreach ($this->list() as $file) {
            $this->set(basename($file, '.php'), $file);
        }
    }

    /**
     * Read config parameters from the file
     *
     * @param string $key - parameter group key (name)
     * @param string|null $file
     * @return type
     */
    public function set($key, $file = null)
    {
        $file = $file ?: "{$key}.php";

        $this->data[$key] = include $this->pathname . $file;
    }

    /**
     * Get requested parameter
     *
     * @param type name
     * @return type
     */
    public function get($key, $element)
    {
        return $this->data[$key][$element];
    }

    /**
     * Get the list of existing configuration files
     *
     * @return array of strings
     */
    protected function list()
    {
        $path = $this->pathname;

        $files = scandir($path);
        $files = array_filter($files, function ($file) use ($path) {
            $filepath = $path . $file;
            return !is_dir($filepath);
        });

        return $files;
    }
}
