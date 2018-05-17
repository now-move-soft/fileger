<?php

namespace nms\fileger\controllers;

use yii\web\Controller;

/**
 * Module settings
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class SettingController extends Controller
{
    /**
     * Display and update module settings
     * 
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
