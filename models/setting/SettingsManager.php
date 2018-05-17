<?php

namespace nms\fileger\models\setting;

use ReflectionClass;
use ReflectionProperty;
use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

/**
 * Settings manager. Wrapper for Setting model. Use this class as Singleton.
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class SettingsManager extends Model
{    
    /**
     * @var static Instance of this class
     */
    private static $instance;
    
    /**
     * Get setting value.
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     * 
     * @param string $name The property name
     * @return mixed The property value
     * @throws UnknownPropertyException If the property is not defined
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        
        return $this->getSetting($name);
    }
    
    /**
     * Set setting value.
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$object->property = $value;`.
     * 
     * @param string $name The property name or the event name
     * @param mixed $value The property value
     * @throws UnknownPropertyException If the property is not defined
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (isset($this->$name)) {
            $this->$name = $value;
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }
    
    /**
     * Get instance of this class
     * 
     * @return self
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Get setting value from database or if not exist from class property
     * 
     * @param string $name Setting name
     * @throws UnknownPropertyException If setting is not defined
     * @return string
     */
    private function getSetting($name)
    {
        $setting = Setting::findOne(['name' => $name]);
        
        if (isset($setting)) {
            return $setting->value;
        } elseif (isset($this->$name)) {
            return $this->$name;
        }
        
        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }
    
    /**
     * Get settings list: protected properties of class.
     * 
     * @return array
     */
    private function getSettingsList()
    {
        $reflection = new ReflectionClass($this);
        
        return ArrayHelper::getColumn($reflection->getProperties(ReflectionProperty::IS_PROTECTED), 'name');
    }
    
    /**
     * Save settings data
     * 
     * @return boolean
     */
    public function save()
    {
        $saveStatus = true;
        
        foreach ($this->getSettingsList() as $settingName) {
            $setting = Setting::findOrCreate(['name' => $settingName]);
            $setting->value = $this->$settingName;
            
            $saveStatus = $saveStatus && $setting->save();
        }
        
        return $saveStatus;
    }
}
