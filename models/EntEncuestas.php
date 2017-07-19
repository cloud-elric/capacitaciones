<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_encuestas".
 *
 * @property string $id_encuesta
 * @property string $id_evento
 * @property string $txt_nombre
 * @property string $b_habilitado
 *
 * @property EntEventos $idEvento
 * @property EntPreguntasEncuestas[] $entPreguntasEncuestas
 * @property EntRespuestas[] $entRespuestas
 */
class EntEncuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_encuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evento', 'txt_nombre'], 'required'],
            [['id_evento', 'b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 500],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => EntEventos::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_encuesta' => 'Id Encuesta',
            'id_evento' => 'Id Evento',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvento()
    {
        return $this->hasOne(EntEventos::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPreguntasEncuestas()
    {
        return $this->hasMany(EntPreguntasEncuestas::className(), ['id_encuesta' => 'id_encuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntRespuestas()
    {
        return $this->hasMany(EntRespuestas::className(), ['id_encuesta' => 'id_encuesta']);
    }
}
