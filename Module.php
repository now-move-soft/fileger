<?php

namespace nms\fileger;

use Yii;

/**
 * File manager module
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'nms\fileger\controllers';
    
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'file';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        Yii::setAlias('@fileger', __DIR__);
        $this->registerTranslations();
    }
    
    /**
     * Register translation messages for module
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/fileger/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@fileger/messages',
            'fileMap' => [
                'modules/fileger/main' => 'main.php',
            ],
        ];
    }
    
    /**
     * Translation method. Wrapper for Yii::t()
     * 
     * @param string $category
     * @param string $message
     * @param array $params
     * @param string $language
     * @see Yii::t()
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        if (!isset(Yii::$app->i18n->translations['modules/fileger/*'])) {
            return $message;
        }
        
        return Yii::t('modules/fileger/' . $category, $message, $params, $language);
    }
}
