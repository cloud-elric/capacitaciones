<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_preguntas".
 *
 * @property string $id_tipo_pregunta
 * @property string $txt_nombre
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntPreguntasEncuestas[] $entPreguntasEncuestas
 */
class CatTiposPreguntas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_preguntas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 200],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_pregunta' => 'Id Tipo Pregunta',
            'txt_nombre' => 'Txt Nombre',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntPreguntasEncuestas()
    {
        return $this->hasMany(EntPreguntasEncuestas::className(), ['id_tipo_pregunta' => 'id_tipo_pregunta']);
    }
}
