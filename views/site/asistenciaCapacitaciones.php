<?php
use yii\helpers\Html;
use yii\grid\GridView;


$this->params['breadcrumbs'][] = 'Fecha de asistencias';
?>
<h1>Fecha de capacitaciones</h1>
<div class="pull-right">
<?php
echo Html::a('Descargar',['site/descargar-lista'], ['class'=>'btn btn-primary']);
?>
</div>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'fch',
            'format' => 'raw',
            'value' => function($data){
                //Cambiar formato fecha
                $fch = new DateTime($data->fch);
                $fecha = date_format($fch, 'j-F-Y');
                $fecha2 = date_format($fch, 'Y-m-d');

                return Html::a($fecha,[
                    'site/mostrar-asistencia',
                    'fch' => $fecha2
                ]);
            }
        ], 
        
        'buttons' => [
            'myButton' => function($url, $model, $key) {     // render your custom button
                return Html::a('Descargar',['site/descargar-lista', 'fch'=>$model->fch_creacion], ['class'=>'btn btn-primary']);
            }
        ]
    ],
]); ?>