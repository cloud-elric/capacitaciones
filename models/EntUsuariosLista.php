<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_usuarios_lista".
 *
 * @property string $id_usuario_lista
 * @property string $id_evento
 * @property string $txt_nombre_completo
 * @property string $fch_creacion
 *
 * @property EntEventos $idEvento
 */
class EntUsuariosLista extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_usuarios_lista';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evento', 'txt_nombre_completo'], 'required'],
            [['id_evento'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['txt_nombre_completo'], 'string', 'max' => 200],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => EntEventos::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_lista' => 'Id Usuario Lista',
            'id_evento' => 'Id Evento',
            'txt_nombre_completo' => 'Txt Nombre Completo',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvento()
    {
        return $this->hasOne(EntEventos::className(), ['id_evento' => 'id_evento']);
    }
}
