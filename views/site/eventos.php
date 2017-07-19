<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<h1>Eventos</h1>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'txt_nombre',
            'format' => 'raw',
            'value' => function($data){

                return Html::a($data->txt_nombre,[
                    'site/asistencia-capacitaciones',
                    'id' => $data->id_evento
                ]);
            }
        ], 
    ],
]); ?>