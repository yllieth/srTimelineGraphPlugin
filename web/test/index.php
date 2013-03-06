<?php 
	// Seule dépendance à Symfony
	class sfException extends Exception {}

	// Chargement des classes
	spl_autoload_register('load_classes');
	function load_classes($class) {
		include __DIR__ . '/../../lib/' . $class . '.class.php';
	}

	// Jeu de test
	$ts = array(strtotime('-3 month'), strtotime('-2 month'), strtotime('-1 month'), time());
	$v1 = array(              10,                  -1500,                   200,    -3540.2);
	$v2 = array(              -6,                  103.8,                   -26,    1022357);
	$ms = array(time() => 'Démonstration');

	$graphConf = TimelineGraphOptions::create()
		->setScaleColumns(array(0,1))
		->setScaleType('allmaximized')
		->setDisplayAnnotations(false)
		->removeOption('zoomStartTime');

	$graph = TimelineGraph::create()
		->setGraphOptions($graphConf)
		->setTimestamps($ts)
		->setValues(array('serie1' => $v1, 'serie2' => $v2))
		->setMilestones($ms);
?>




<!DOCTYPE html>
<html>
	<head>
		<title>Essai de srTimelineGraphPlugin</title>
		<script type="text/javascript" src="../js/graph.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	</head>

	<body>
		<h1>Graphique</h1>
		<div id="graph"></div>
		
		<h1>Tableau de valeurs</h1>
		<div id="table"></div>

		<?php $graph->load_google_javascripts("graph","table")
					->render() 
		?>
	</body>
</html>