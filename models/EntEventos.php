<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_eventos".
 *
 * @property string $id_evento
 * @property string $txt_nombre
 * @property string $b_habilitado
 *
 * @property EntEncuestas[] $entEncuestas
 * @property EntUsuariosLista[] $entUsuariosListas
 */
class EntEventos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_eventos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'txt_nombre' => 'Txt Nombre',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEncuestas()
    {
        return $this->hasMany(EntEncuestas::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntUsuariosListas()
    {
        return $this->hasMany(EntUsuariosLista::className(), ['id_evento' => 'id_evento']);
    }
}
