<?php

namespace app\services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RenderTwigServices implements RenderI
{
    protected $twig;

    /**
     * @param $twig
     */
    public function __construct()
    {
        $loader = new FilesystemLoader([
            dirname(__DIR__) . '/views/layouts/',
        ]);
        $this->twig = new Environment($loader);
    }

    public function render($template, $params = [])
    {
        $template .= '.twig';
        return $this->twig->render($template, $params);
    }
}
