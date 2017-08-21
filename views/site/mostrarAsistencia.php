<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Fecha asistencias', 'url' => ['asistencia-capacitaciones']];
$this->params['breadcrumbs'][] = $fch;
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
        'txt_nombre_completo',
        'txt_empresa',
        'buttons' => [
            'myButton' => function($url, $model, $key) {     // render your custom button
                return Html::a('Descargar',['site/descargar-lista', 'fch'=>$model->fch_creacion], ['class'=>'btn btn-primary']);
            }
        ] 
    ],
]); ?>