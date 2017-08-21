<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntEventos;
use yii\data\ActiveDataProvider;
use app\models\EntUsuariosLista;
use app\models\EntCapacitaciones;

use app\models\ViewFechasEncuestas;
use app\models\EntRespuestas;
use app\models\EntPreguntasEncuestas;
use app\models\ViewFechasCapacitaciones;
use yii\db\Expression;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEventos(){
        $query = EntEventos::find()->where(['b_habilitado'=>1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('eventos', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAsistenciaCapacitaciones($id = 1){
        $data = EntCapacitaciones::find()->where(['id_evento'=>$id])->one();
        //Cambiar formato fecha
        $fch = new \DateTime($data->fch_creacion);
        $fecha = date_format($fch, 'Y-m-d');

        $query = EntCapacitaciones::find()->where(['id_evento'=>$id])->groupBy([new Expression($fecha)]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $query = ViewFechasCapacitaciones::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);


        return $this->render('asistenciaCapacitaciones', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionMostrarAsistencia($fch = null){
        $fecha = date($fch);
		$maniana = strtotime('+1 day',strtotime($fecha));
        $maniana = date('Y-m-d', $maniana);
        
        $query = EntUsuariosLista::find()->where(['>=', 'fch_creacion', $fch])->andWhere(['<=', 'fch_creacion', $maniana]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('mostrarAsistencia', [
            'dataProvider' => $dataProvider,
            'fch'=>$fch
        ]);
    }

    public function actionMostrarDatosEncuesta($fch){
        $idEncuesta = 1;

        $respuestas = EntRespuestas::find()->where('date_format(fch_creacion,"%Y-%m-%d")=:fch', [':fch'=>$fch])->all();
        $respuestasFecha = [];
        foreach($respuestas as $respuesta){
            $respuestasFecha[] = $respuesta->id_respuesta;
        }

        $preguntas = EntPreguntasEncuestas::find()->where('id_encuesta=:idEncuesta',[':idEncuesta'=>$idEncuesta])->all();
    

        return $this->render("mostrar-datos-encuesta", ['respuestasFecha'=>$respuestasFecha, 'preguntas'=>$preguntas]);
    }

    public function actionListEncuestasByFecha(){
        $query = ViewFechasEncuestas::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render("list-encuestas-by-fecha", ['dataProvider' => $dataProvider]);
    }

    
}
