<?php

namespace app\services;

class RenderServices implements RenderI
{
    public function render($template, $params = [])
    {
        $content = $this->renderTmpl($template, $params);

        $title = 'My Shop';
        if (!empty($params['title'])) {
            $title = $params['title'];
        }

        return $this->renderTmpl(
            'main',
            [
                'content' => $content,
                'title' => $title,
            ]
        );
    }

    public function renderTmpl($template, $params = [])
    {
        ob_start();
        extract($params);
        include dirname(__DIR__) . '/views/layouts/' . $template . '.php';
        return ob_get_clean();
    }
}
