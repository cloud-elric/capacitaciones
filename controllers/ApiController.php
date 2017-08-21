<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\EntCapacitaciones;
use app\models\EntUsuariosLista;
use app\models\EntEncuestas;
use app\models\EntRespuestas;
use app\models\EntRespuestasEncuestas;
use yii\db\Transaction;


class ApiController extends Controller
{
    public $idEvento = 1;
    public $enableCsrfValidation = false;

    public function actionSaveListAsistentes()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['error'] = true;
        $respuesta['message'] = 'Faltan datos';

        if (isset($_REQUEST['nombre']) && isset($_REQUEST['apellido']) && isset($_REQUEST['correo']) && isset($_REQUEST['empresa'])) {
            //$listaAsistentes = $_REQUEST['asistentes'];

            $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);

            $error = false;

            if ($capacitacion = EntCapacitaciones::saveCapacitacion($this->idEvento)) {
                //foreach($listaAsistentes as $asistentes){
                $asistente = new EntUsuariosLista();
                $asistente->txt_nombre_completo = $_REQUEST['nombre'];
                $asistente->txt_apellido = $_REQUEST['apellido'];
                $asistente->txt_correo = $_REQUEST['correo'];
                $asistente->txt_empresa = $_REQUEST['empresa'];
                $asistente->id_capacitacion = 1;//$capacitacion->id_capacitacion;

                if (!$asistente->save()) {
                    $error = true;
                    $respuesta["errors"][0] = $asistente->errors;
                }
                //}

                if ($error) {
                    $respuesta['message'] = 'Ocurrio un problema';
                    $transaction->rollBack();
                }
                else {
                    $respuesta['error'] = false;
                    $respuesta['message'] = 'Información guardada con exito';
                    $respuesta['capacitacion'] = $capacitacion;
                    $transaction->commit();
                }

            }
            else {
                $respuesta['message'] = 'Ocurrio un problema al guardar la capacitacion';
                $transaction->rollBack();
            }
        }

        return $respuesta;

    }

    public function actionGetPreguntas($idEvento = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['error'] = true;
        $respuesta['message'] = 'Faltan datos';
        $encuesta = EntEncuestas::find()->where("id_evento=:idEvento", ['idEvento' => $idEvento])->one();

        if ($encuesta) {
            $respuesta['error'] = false;
            $respuesta['message'] = 'Datos encontrados';
            $respuesta['preguntas'] = $encuesta->entPreguntasEncuestas;
        }

        return $respuesta;

    }

    public function actionSavePreguntas($idEvento = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['error'] = true;
        $respuesta['message'] = 'Faltan datos';

        $encuesta = EntEncuestas::find()->where("id_evento=:idEvento", ['idEvento' => $idEvento])->one();

        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);

        if ($encuesta) {
            if (isset($_REQUEST['valor0']) && isset($_REQUEST['valor1']) && isset($_REQUEST['valor2']) && isset($_REQUEST['valor3']) && isset($_REQUEST['valor4']) && isset($_REQUEST['valor5'])) {
                $respuestaM = new EntRespuestas();
                $respuestaM->id_encuesta = $encuesta->id_encuesta;
                $respuestaM->save();

                $error = false;

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor0'], 1)) {
                    $error = true;
                    $respuesta['message'] = 'No se pueod guardar la respuesta 0';
                }

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor1'], 2)) {
                    $error = true;
                    $respuesta['message'] = 'No se pueod guardar la respuesta 1';
                }

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor2'], 3)) {
                    $error = true;
                    $respuesta['message'] = 'No se pueod guardar la respuesta 2';
                }

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor3'], 4)) {
                    $error = true;
                    $respuesta['message'] = 'No se pueod guardar la respuesta 3';
                }

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor4'], 5)) {
                    $error = true;
                    $respuesta['message'] = 'No se pueod guardar la respuesta 4';
                }

                if (!$this->guardarPregunta($respuestaM->id_respuesta, $_REQUEST['valor5'], 6)) {
                    $error = true;
                    $respuesta['message'] = 'No se pudieron guardar los comentarios';
                }

                if ($error) {
                    $transaction->rollBack();
                }
                else {
                    $respuesta['error'] = false;
                    $respuesta['message'] = 'Datos guardados correctamente';
                    $transaction->commit();
                }

            }
            else {
                $respuesta['message'] = 'Faltan datos';
            }
        }

        return $respuesta;
    }

    public function setValoresEncuesta($valor)
    {

        switch ($valor) {
            case '1' :
                $nuevoValor = "Muy mala";
                break;
            case '2' :
                $nuevoValor = "Mala";
                break;
            case '3' :
                $nuevoValor = "Regular";
                break;
            case '4' :
                $nuevoValor = "Buena";
                break;
            case '5' :
                $nuevoValor = "Muy buena";
                break;

            default :
                $nuevoValor = "Sin valor";
                break;
        }

        return $nuevoValor;
    }

    public function guardarPregunta($idRespuesta, $valor, $idPregunta)
    {
        $respuestaEncuesta = new EntRespuestasEncuestas();
        $respuestaEncuesta->id_pregunta = $idPregunta;
        $respuestaEncuesta->id_respuesta_creacion = $idRespuesta;
        $respuestaEncuesta->txt_valor = $this->setValoresEncuesta($valor);

        return $respuestaEncuesta->save();
    }

}
