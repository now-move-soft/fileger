<?php

namespace nms\fileger\models\setting;

use nms\fileger\models\db\ActiveRecord;

/**
 * Active record for table '{{%fm_setting}}'
 * 
 * @author Michael Naumov <vommuan@gmail.com>
 * @copyright 2018 Now Move Soft
 * @since v0.1
 */
class Setting extends ActiveRecord
{    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            
            [['value'], 'trim'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fm_setting}}';
    }
}
