<?php
use app\models\EntRespuestasEncuestas;
use yii\web\View;
$this->params['breadcrumbs'][] = ['label' => 'Fecha encuestas', 'url' => ['list-encuestas-by-fecha']];
$this->params['breadcrumbs'][] = 'Datos estadístico';
?>
<h1>Estadísticas</h1>

<?php
$i=0;
foreach($preguntas as $pregunta){
    if($pregunta->id_tipo_pregunta==1){
    ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><?=$pregunta->txt_pregunta?></h4>
    </div>
    <div class="panel-body">
<?php
    $respuestasValores = EntRespuestasEncuestas::find()
                            ->select(['COUNT(*) AS count_valores', 'txt_valor'])
                            ->where('id_pregunta=:idPregunta', [':idPregunta'=>$pregunta->id_pregunta])
                            ->andWhere(['in','id_respuesta_creacion',$respuestasFecha])
                            ->groupBy(['txt_valor'])
                            ->all();
    $sum = 0;
    $labels = '';
    $valores = '';
    foreach($respuestasValores as $respuestaValores){
        $mul = $respuestaValores->count_valores;
        $sum += $mul;
        $labels.= '"'.$respuestaValores->txt_valor.'", ';
        $valores.= $respuestaValores->count_valores.',';
    }

    foreach($respuestasValores as $respuestaValores){
        $promedio = ($respuestaValores->count_valores * 100) / $sum;
?>
    
        <div class="col-md-2">
            <div class="panel">
                <div class="panel-body">
                    <?=$respuestaValores->txt_valor?><br><span class='label label-default'>Promedio: <?=number_format($promedio, 0)?>%</span>
                </div>
            </div>
        </div> 
       

    <?php
    }
    echo "<br>Total:".$sum."<br><br><br>";

    ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <canvas id="myChart<?=$i?>" width="100" height="100"></canvas>
    </div>
</div>


<?php
$this->registerJs(
    'var ctx = document.getElementById("myChart'.$i.'").getContext("2d");
var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ['.$labels.'],
        datasets: [{
            label: "# de usuarios",
            data: ['.$valores.'],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});',
    View::POS_END,
    'my-button-handler'.$i
);
?>
    </div>
</div>
<?php
$i++;

}else{

$respuestasValores = EntRespuestasEncuestas::find()
    ->where('id_pregunta=:idPregunta', [':idPregunta'=>$pregunta->id_pregunta])
    ->andWhere('id_tipo_pregunta=:idTipoPregunta', [':idTipoPregunta'=>$pregunta->id_tipo_pregunta])
    ->one();
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4><?=$pregunta->txt_pregunta?></h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body">
                        <p>
                            <?=$respuestasValores->txt_valor?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div>

<?php
}
}


?>