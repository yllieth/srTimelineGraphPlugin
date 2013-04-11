README
======

Ce plugin permet de configurer simplement un graphique qui sera généré par 
l'API Google [annotatedTimeline](https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr).

[Voir sur GitHub](https://github.com/yllieth/srTimelineGraphPlugin.git)

> version stable : 1.0
> dernière modification : 11 avril 2013

Préambule
---------

Ce plugin est initialiement écrit pour être intégrer dans un projet Symfony 1.x.
Cependant, la seule dépendance avec ce Framework est l'utilisation de la classe `sfException`.

Un exemple est fourni dans le fichier `web/test/index.php`.
Ce fichier est un exemple destiné à être utilisé en l'état afin de faire des tests.

Un des intérêts de ce plugin réside dans l'autocomplétion des options proposées par Google.
La documentation est reprise telle quelle de la documentation de l'API.


Utilisation au sein d'un projet Symfony
---------------------------------------

## Installation

### Via git
``` sh
git clone git://github.com/yllieth/srTimelineGraphPlugin.git <path-to-clone>
```

## Exemple d'utilisation

**Dans l'action**

``` php
// apps/______/modules/_____/actions/actions.class.php

// Jeu de test
$ts = array(strtotime('-3 month'), strtotime('-2 month'), strtotime('-1 month'), time());
$v1 = array(              10,                  -1500,                   200,    -3540.2);
$v2 = array(              -6,                  103.8,                   -26,    1022357);
$ms = array(time() => 'Démonstration');

// Configuration des options proposées par Google dans son API
$graphConf = TimelineGraphOptions::create()
	->setScaleColumns(array(0,1))
	->setScaleType('allmaximized')
	->setDisplayAnnotations(false)
	->removeOption('zoomStartTime');

// Création du graphique
$graph = TimelineGraph::create()
	->setGraphOptions($graphConf)
	->setTimestamps($ts)
	->setValues(array('serie1' => $v1, 'serie2' => $v2))
	->setMilestones($ms);
```

> Note : Il est préférable de faire l'appel à `setGraphOptions($graphConf)` 
> dès la création du graphique. Cela permet à la fonction `setMilestones()` 
> de réaliser un contrôle supplémentaire afin de garantir l'affichage des 
> annotations.

**Dans un template**

``` html
<h1>Graphique</h1>
<div id="graph"></div>
		
<h1>Tableau de valeurs</h1>
<div id="table"></div>

<?php $graph->load_google_javascripts("graph","table")->render() ?>
```

> Note : les div identifiées `graph` et `table`  vont recevoir 
> le graphique et le tableau de valeurs.

> Note : la div identifiée `table` est facultative. Si elle n'est pas donnée
> à la fonction, le tableau de valeurs ne sera pas affiché.

Utilisation à l'extérieur d'un projet Symfony
---------------------------------------------

La seule chose nécessaire est le chargement des classes contenues dans `lib/`.
Il faut donc s'assurer que l'autoloader examine ce dossier (voir `web/test/index.php`).

Rendu
-----

![](web/test/screenshot.png?raw=true)