<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_usuarios_lista".
 *
 * @property string $id_usuario_lista
 * @property string $id_capacitacion
 * @property string $txt_nombre_completo
 * @property string $fch_creacion
 *
 * @property EntCapacitaciones $idCapacitacion
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
            [['id_capacitacion', 'txt_nombre_completo'], 'required'],
            [['id_capacitacion'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['txt_nombre_completo'], 'string', 'max' => 200],
            [['id_capacitacion'], 'exist', 'skipOnError' => true, 'targetClass' => EntCapacitaciones::className(), 'targetAttribute' => ['id_capacitacion' => 'id_capacitacion']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_lista' => 'Id Usuario Lista',
            'id_capacitacion' => 'Id Capacitacion',
            'txt_nombre_completo' => 'Nombre Completo',
            'txt_empresa'=>'Empresa',
            'fch_creacion' => 'Fch Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCapacitacion()
    {
        return $this->hasOne(EntCapacitaciones::className(), ['id_capacitacion' => 'id_capacitacion']);
    }
}
