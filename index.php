#!/usr/bin/env php
<?php

$di = new \Phalcon\Di\FactoryDefault();
$di->setShared('view', function () {
    $eventsManager = $this->getShared('eventsManager');

    $view = new \Phalcon\Mvc\View\Simple();
    $view->setEventsManager($eventsManager);
    $view->setViewsDir(__DIR__ . '/views/');
    $view->registerEngines([
        '.volt' => function ($view) {
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $this);
            $volt->setOptions([
                'compiledExtension' => '.cache',
                'compiledSeparator' => '_',
                'autoescape' => false,
            ]);
            $compiler = $volt->getCompiler();


            return $volt;
        }
    ]);
    return $view;
});

class SomeController extends \Phalcon\Mvc\Controller
{
    public function testAction()
    {
        echo $this->view->render('test.volt');
    }
}

(new SomeController())
    ->testAction();