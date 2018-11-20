

<?php

header('Content-Type: text/html; charset=utf-8');
require('./vendor/autoload.php');

function chartLine($xAxisData, $seriesData, $title = '')
{
    $chart = new Hisune\EchartsPHP\ECharts();
    $xAxis = new Hisune\EchartsPHP\Doc\IDE\XAxis();
    $yAxis = new Hisune\EchartsPHP\Doc\IDE\YAxis();

    $color = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
    shuffle($color);

    $title && $chart->title->text = $title;
    $chart->color = $color;
    $chart->tooltip->trigger = 'axis';
    $chart->toolbox->show = true;
    $chart->toolbox->feature->dataZoom->yAxisIndex = 'none';
    $chart->toolbox->feature->dataView->readOnly = false;
    $chart->toolbox->feature->magicType->type = ['line', 'bar'];
    $chart->toolbox->feature->saveAsImage = [];

    $xAxis->type = 'category';
    $xAxis->boundaryGap = false;
    $xAxis->data = $xAxisData;

    foreach($seriesData as $ser){
        $chart->legend->data[] = $ser['name'];
        $series = new \Hisune\EchartsPHP\Doc\IDE\Series();
        $series->name = $ser['name'];
        $series->type = isset($ser['type']) ?: 'line';
        $series->data = $ser['data'];
        $chart->addSeries($series);
    }

    $chart->addXAxis($xAxis);
    $chart->addYAxis($yAxis);

    $chart->initOptions->renderer = 'svg';
    $chart->initOptions->width = '800px';
    return $chart->render(uniqid());
}




use Hisune\EchartsPHP\ECharts;
use Hisune\EchartsPHP\Doc\IDE\YAxis;
$color = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
shuffle($color);
$chart = new ECharts();
$chart->color=$color;
$chart->tooltip->show = true;
$chart->legend->data[] = '销量';
$chart->xAxis[] = array(
    'type' => 'category',
    'data' => array("衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子")
);

$yAxis = new YAxis();
$yAxis->type = 'value';
$chart->addYAxis($yAxis);

$chart->series[] = array(
    'name' => '销量',
    'type' => 'bar',
    'data' => array(5, 20, 40, 10, 10, 20)
);
?>








<div  style="height: 530px; width: 80%;">
   <?php 
    echo chartLine(
    ['SEM RESULTS','ATTENDANCE','PUBLICATIONS','RESEARCH','EXTRA CURRICULUM','STUDENT RATING'],
    [
        ['name' => '2018', 'data' => [9.0,7.9,9.0,8.8,4.6,9.1]],
        ['name' => '2019', 'data' => [8.4,9.5,7.0,5.9,8.4,8.3]],
    ],
    'DID YOU IMPROVE..?'
);
?>
</div>

<div  style="height: 530px; width: 80%;">
   <?php 
 echo $chart->render('simple-custom-id');
?>
</div>

