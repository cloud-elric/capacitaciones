<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_fechas_encuestas".
 *
 * @property string $fch
 */
class ViewFechasEncuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_fechas_encuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fch'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fch' => 'Fecha',
        ];
    }
}
