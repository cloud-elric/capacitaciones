<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_respuestas".
 *
 * @property string $id_respuesta
 * @property string $id_encuesta
 * @property string $fch_creacion
 *
 * @property EntEncuestas $idEncuesta
 * @property EntRespuestasEncuestas[] $entRespuestasEncuestas
 */
class EntRespuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_respuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_encuesta'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_encuesta'], 'exist', 'skipOnError' => true, 'targetClass' => EntEncuestas::className(), 'targetAttribute' => ['id_encuesta' => 'id_encuesta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_respuesta' => 'Id Respuesta',
            'id_encuesta' => 'Id Encuesta',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEncuesta()
    {
        return $this->hasOne(EntEncuestas::className(), ['id_encuesta' => 'id_encuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntRespuestasEncuestas()
    {
        return $this->hasMany(EntRespuestasEncuestas::className(), ['id_respuesta_creacion' => 'id_respuesta']);
    }
}
