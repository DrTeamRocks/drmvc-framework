<?php namespace DrMVC\Core;

/**
 * Class View for work with views
 */
class View
{
    /**
     * @var $data
     */
    public $data;

    /**
     * View class constructor
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * Include layout file
     *
     * @param string $path
     * @param bool $data
     * @return mixed|null
     */
    public function render($path, $data = false)
    {
        if ($data === false) $data = $this->data;

        // Application view
        $appfile = APPPATH . 'Views' . DIRECTORY_SEPARATOR . THEME . DIRECTORY_SEPARATOR . $path . '.php';

        switch (true) {
            case file_exists($appfile):
                $file = include($appfile);
                break;
            default:
                $file = NULL;
                break;
        }

        return $file;
    }

}
