<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<h1>Fecha de capacitaciones</h1>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'txt_nombre_completo' 
    ],
]); ?>