<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<h1>Encuestas</h1>

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
                    'site/mostrar-datos-encuesta',
                    'fch' => $fecha2
                ]);
            }
        ], 
    ],
]); ?>