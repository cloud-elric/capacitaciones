<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_capacitaciones".
 *
 * @property string $id_capacitacion
 * @property string $id_evento
 * @property string $fch_creacion
 *
 * @property EntEventos $idEvento
 * @property EntEncuestas[] $entEncuestas
 * @property EntUsuariosLista[] $entUsuariosListas
 */
class EntCapacitaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_capacitaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evento'], 'required'],
            [['id_evento'], 'integer'],
            [['fch_creacion'], 'safe'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => EntEventos::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_capacitacion' => 'Id Capacitacion',
            'id_evento' => 'Id Evento',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntEncuestas()
    {
        return $this->hasMany(EntEncuestas::className(), ['id_capacitacion' => 'id_capacitacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntUsuariosListas()
    {
        return $this->hasMany(EntUsuariosLista::className(), ['id_capacitacion' => 'id_capacitacion']);
    }


    public static function saveCapacitacion($idEvento){
        $capacitacion = new EntCapacitaciones();
        $capacitacion->id_evento = $idEvento;
        
        if($capacitacion->save()){
            return $capacitacion;
        }else{
            return false;
        } 

        
    }
}
