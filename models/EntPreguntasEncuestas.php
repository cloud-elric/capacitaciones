<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_preguntas_encuestas".
 *
 * @property string $id_pregunta
 * @property string $id_tipo_pregunta
 * @property string $id_encuesta
 * @property string $num_orden
 * @property string $txt_pregunta
 * @property string $b_habilitado
 *
 * @property CatTiposPreguntas $idTipoPregunta
 * @property EntEncuestas $idEncuesta
 * @property EntRespuestasEncuestas[] $entRespuestasEncuestas
 */
class EntPreguntasEncuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_preguntas_encuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_pregunta', 'id_encuesta', 'num_orden', 'b_habilitado'], 'integer'],
            [['id_encuesta', 'num_orden', 'txt_pregunta'], 'required'],
            [['txt_pregunta'], 'string', 'max' => 5000],
            [['id_tipo_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposPreguntas::className(), 'targetAttribute' => ['id_tipo_pregunta' => 'id_tipo_pregunta']],
            [['id_encuesta'], 'exist', 'skipOnError' => true, 'targetClass' => EntEncuestas::className(), 'targetAttribute' => ['id_encuesta' => 'id_encuesta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pregunta' => 'Id Pregunta',
            'id_tipo_pregunta' => 'Id Tipo Pregunta',
            'id_encuesta' => 'Id Encuesta',
            'num_orden' => 'Num Orden',
            'txt_pregunta' => 'Txt Pregunta',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoPregunta()
    {
        return $this->hasOne(CatTiposPreguntas::className(), ['id_tipo_pregunta' => 'id_tipo_pregunta']);
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
        return $this->hasMany(EntRespuestasEncuestas::className(), ['id_pregunta' => 'id_pregunta']);
    }
}
