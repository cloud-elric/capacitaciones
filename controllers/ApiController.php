<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class ApiController extends Controller
{
    public $idEvento = 1;

    public function actionSaveList(){

         Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['error'] = true;
        $respuesta['message'] = 'Faltan datos';

    }
    
}
