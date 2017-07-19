<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_respuestas_encuestas".
 *
 * @property string $id_respuesta
 * @property string $id_pregunta
 * @property string $id_respuesta_creacion
 * @property string $txt_valor
 *
 * @property EntPreguntasEncuestas $idPregunta
 * @property EntRespuestas $idRespuestaCreacion
 */
class EntRespuestasEncuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_respuestas_encuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pregunta', 'id_respuesta_creacion', 'txt_valor'], 'required'],
            [['id_pregunta', 'id_respuesta_creacion'], 'integer'],
            [['txt_valor'], 'string', 'max' => 200],
            [['id_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => EntPreguntasEncuestas::className(), 'targetAttribute' => ['id_pregunta' => 'id_pregunta']],
            [['id_respuesta_creacion'], 'exist', 'skipOnError' => true, 'targetClass' => EntRespuestas::className(), 'targetAttribute' => ['id_respuesta_creacion' => 'id_respuesta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_respuesta' => 'Id Respuesta',
            'id_pregunta' => 'Id Pregunta',
            'id_respuesta_creacion' => 'Id Respuesta Creacion',
            'txt_valor' => 'Txt Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPregunta()
    {
        return $this->hasOne(EntPreguntasEncuestas::className(), ['id_pregunta' => 'id_pregunta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRespuestaCreacion()
    {
        return $this->hasOne(EntRespuestas::className(), ['id_respuesta' => 'id_respuesta_creacion']);
    }
}
