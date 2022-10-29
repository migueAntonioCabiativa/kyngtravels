<?php
require_once ('layouts/jpgraph/jpgraph.php');
require_once ('layouts/jpgraph/jpgraph_line.php');
require_once ('layouts/jpgraph/jpgraph_scatter.php');
require_once ('layouts/jpgraph/jpgraph_regstat.php');
require_once ('layouts/jpgraph/jpgraph_ttf.inc.php');




//GRAFICA 1
$resultGrafica = $CON->grafica_hora();
$i=0;
foreach ($resultGrafica as $value){
$xdata[$i] = $value['0'];
$ydata[$i] = $value['1'];
$i++;
}


// Get the interpolated values by creating
// a new Spline object.
$spline = new Spline($xdata,$ydata);

// For the new data set we want 40 points to
// get a smooth curve.
list($newx,$newy) = $spline->Get(20);

// Create the graph
$g = new Graph(300,200);
//$g->title->Set("Natural cubic splines");

//$g->img->SetAntiAliasing();

// We need a linlin scale since we provide both
// x and y coordinates for the data points.
$g->SetScale('linlin',0,0,'4','24');
$g->yaxis->Hide();
$g->yaxis->Hide();


$lplot = new LinePlot($newy,$newx);
$g->Add($lplot);
$lplot->SetFillColor("#25A548@0.9");
$lplot->SetColor("#25A548");


$sp1 = new ScatterPlot($newy,$newx);
$sp1->mark->SetType(MARK_FILLEDCIRCLE);
$sp1->mark->SetFillColor("#FFFFFF");
$sp1->mark->SetColor("#25A548");
$sp1->mark->SetSize(3);


$sp1->SetImpuls();
$sp1->SetColor("#CCCCCC");

$g->Add($sp1);

$g->Stroke('reports/imgs/grafica1.png');
?>
