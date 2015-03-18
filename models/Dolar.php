<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dolar".
 *
 * @property integer $id
 * @property double $dolar
 * @property string $created_at
 */
class Dolar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dolar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dolar'], 'number'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dolar' => 'Dolar',
            'created_at' => 'Created At',
        ];
    }
}
