<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Fecha asistencias', 'url' => ['asistencia-capacitaciones']];
$this->params['breadcrumbs'][] = $fch;
?>
<h1>Fecha de capacitaciones</h1>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'txt_nombre_completo',
            'label' => 'Nombre',
            'value' => function($model) { return $model->txt_nombre_completo  . " " . $model->txt_apellido ;},
        ],
        'txt_empresa'
    ],
]); ?>