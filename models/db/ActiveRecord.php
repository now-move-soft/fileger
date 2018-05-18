<?php

namespace nms\fileger\models\db;

/**
 * Extended active record.
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class ActiveRecord extends yii\db\ActiveRecord
{
    /**
     * Find existing record or create new with current parameters.
     * 
     * @param array $params Parameters
     * @return static
     */
    public static function findOrCreate($params)
    {
        $model = static::findOne($params);
            
        if (isset($model)) {
            return $model;
        }
        
        return new static($params);
    }
}
