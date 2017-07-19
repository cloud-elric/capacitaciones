<?php
use yii\helpers\Html;
use yii\grid\GridView;


$this->params['breadcrumbs'][] = 'Fecha de asistencias';
?>
<h1>Fecha de capacitaciones</h1>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'fch_creacion',
            'format' => 'raw',
            'value' => function($data){
                //Cambiar formato fecha
                $fch = new DateTime($data->fch_creacion);
                $fecha = date_format($fch, 'j-F-Y');
                $fecha2 = date_format($fch, 'Y-m-d');

                return Html::a($fecha,[
                    'site/mostrar-asistencia',
                    'fch' => $fecha2
                ]);
            }
        ], 
    ],
]); ?>