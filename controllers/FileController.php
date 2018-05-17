<?php

namespace nms\fileger\controllers;

use yii\web\Controller;

/**
 * Main and default controller for module
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class FileController extends Controller
{
    /**
     * Display file manager
     * 
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
