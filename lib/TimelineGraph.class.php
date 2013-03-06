<?php 

class TimelineGraph extends GraphConf {
	
	// #####################################################################################################
	// ###                                           CONSTANTES                                          ###
	// #####################################################################################################
	
	/**
	 * @copydoc TimelineGraph::setTimestamps()
	 * @return array
	 */
	private $timestamp = array();
	
	/**
	 * @copydoc TimelineGraph::setMilestones()
	 * @return array
	 */
	private $milestones = array();
	
	// #####################################################################################################
	// ###                                           ACCESSEURS                                          ###
	// #####################################################################################################
	
	/**
	 * Renvoie le tableau des timestamps nécessaires pour un graphique temporel.
	 * Il s'agit de timestamps au format unix (en secondes).
	 * 
	 * @return array
	 * @author Sylvain {20/02/2013}
	 */
	public function getTimestamps() 
	{ 
		return $this->timestamp; 
	}
	
	/**
	 * Définit le tableau des timestamps nécessaires pour un graphique temporel.
	 * Il s'agit de timestamps au format unix (en secondes).
	 * 
	 * Avant d'être définit, le tableau est contrôlé pour s'assurer de la validité des données :
	 * - entiers positifs
	 * - en nombre identique aux valeurs de chaque courbe
	 * 
	 * @return TimelineGraph <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setTimestamps(Array $timestamp) 
	{
		$this->checkTimestamps($timestamp);
		$this->timestamp = $timestamp;
		
		return $this;
	}
	
	/**
	 * Renvoie le tableau des jalons à reporter sur le graphique.
	 * Ces jalons ne sont pas obligatoires pour afficher générer le graphique.
	 * 
	 * @return array
	 * @author Sylvain {20/02/2013}
	 */
	protected function getMilestones()
	{
		return $this->milestones;
	}
	
	/**
	 * Définit le tableau des jalons à reporter sur le graphique.
	 * Ces jalons ne sont pas obligatoires pour afficher générer le graphique.
	 * 
	 * Avant d'être définit, le tableau est contrôlé pour s'assurer de la validité des données :
	 * - tableau associatif <em>timestamp</em> => <em>annotation</em>
	 * 
	 * De plus, on active l'option <code>displayAnnotations</code> de manière à afficher cette annotation.
	 * 
	 * @param array $milestones Tableau associatif <em>timestamp</em> => <em>annotation</em>
	 * @return TimelineGraph <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setMilestones(Array $milestones = array())
	{
		$this->checkMilestones($milestones);
		$this->milestones = $milestones;
		
		if ($this->hasGraphOptions()){
			$options = $this->getGraphOptions();
			if (!array_key_exists('displayAnnotations', $options) || $options['displayAnnotations'] === false) {
				$this->graphOptions['displayAnnotations'] = true;
			}
		}
		
		return $this;
	}
	
	/**
	 * Définit les options de paramètrage du graphique.
	 * 
	 * @param  TimelineGraphOptions $graphOptions
	 * @throws TimelineGraphException
	 * @return TimelineGraph <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setGraphOptions($graphOptions) 
	{
		if ($graphOptions instanceof TimelineGraphOptions) {
			return parent::setGraphOptions($graphOptions->toArray());
		} else {
			throw new TimelineGraphException("TimelineGraph::setGraphOptions only accepts TimelineGraphOptions in parameter");
		}
		
		return $this;
	}
	
	
	
	// #####################################################################################################
	// ###                                      FONCTIONS PUBLIQUES                                      ###
	// #####################################################################################################
	
	/**
	 * Déclenche la génération du graphique.
	 * 
	 * Cette fonction doit IMPERATIVEMENT être appelée APRES <code>load_google_javascripts()</code> 
	 * pour pouvoir utiliser sans problèmes le code Javascript.
	 * 
	 * @throws TimelineGraphException si on ne sait pas dans quelle(s) div(s) insérer le graphique (et le tableau de valeurs)
	 * @author Sylvain
	 */
	public function render()
	{
		if ($this->hasGraphDivId() === false && $this->hasTableDivId() === false) {
			throw new TimelineGraphException("Ne pas oublier de faire appel à load_google_javascripts pour définir les <div> qui recevront le graphique et / ou la table de données");
		}
		
		$js_graph_div = (isset($this->graphDivId)) ? $this->getGraphDivId() : 'null';
		$js_table_div = (isset($this->tableDivId)) ? $this->getTableDivId() : 'null';
		$js_datas = json_encode($this->renderConfig());
		
		echo "<script type='text/javascript'>timelineGrapher(" . $js_datas . ",'" . $js_graph_div . "','" . $js_table_div . "');</script>";
	}
	
	/**
	 * Insère, dans la page web, les scripts nécessaires à l'affichage du graphique.
	 * 
	 * Cette fonction doit IMPERATIVEMENT être appelée AVANT <code>render()</code> 
	 * car elle permet de pouvoir instancier les objets Javascript requis.
	 * 
	 * @param  string $graph_div
	 * @param  string $table_div
	 * @return TimelineGraph
	 * @author Sylvain
	 */
	public function load_google_javascripts($graph_div = null, $table_div = null)
	{
		$this->setGraphDivId($graph_div);
		$this->setTableDivId($table_div);
		
		$google_packages_to_load = array();
		if (isset($graph_div)) $google_packages_to_load[] = 'annotatedtimeline';
		if (isset($table_div)) $google_packages_to_load[] = 'table';
		
		echo "<script type='text/javascript' src='/srTimelineGraphPlugin/js/graph.js'></script>";
		echo "<script type='text/javascript' src='http://www.google.com/jsapi'></script>";
		echo "<script type='text/javascript'>google.load('visualization','1',{packages:['" . implode(',', $google_packages_to_load) . "']});</script>";
		
		return $this;
	}
	
	/**
	 * Affiche la configuration du graphique pour essayer d'y voir plus clair
	 * 
	 * @author Sylvain {06/03/2013}
	 */
	public function debug()
	{
		var_dump($this->renderConfig());
	}
	
	// #####################################################################################################
	// ###                                       FONCTIONS PRIVEES                                       ###
	// #####################################################################################################
	
	/**
	 * Vérifie la validité des données contenues dans le tableau de timestamps.
	 * Pour être valide, ces données doivent être :
	 * - des entiers positifs
	 * - en nombre identique aux valeurs de chaque courbe
	 * 
	 * @param  array $array
	 * @throws TimelineGraphException Si une donnée est mal formatée
	 * @author Sylvain {20/02/2013}
	 */
	private function checkTimestamps($array)
	{
		$values = $this->getValues();
		if (count($values) > 0){
			
		}
		
		foreach ($array as $key => $value){
			if (!is_numeric($key) || $key < 0 || !is_numeric($value) || $value <= 0){
				throw new TimelineGraphException("Le tableau de timestamps contient des données mal formatées [$key => $value]");
			}
		}
	}
	
	private function checkMilestones($array)
	{
		
	}
	
	/**
	 * Renvoie la configuration du graphique sous la forme d'un tableau. 
	 * 
	 * Ce tableau, une fois encodé en JSON sera décodé par les fonctions 
	 * javascript du fichier graph.js afin de réaliser les appels aux API Google.
	 * 
	 * @param  boolean $json [FACULTATIF - DEFAULT: false] Indique sin on souhaite le résultat en PHP (<code>false</code>) ou en JSON (<code>true</code>)
	 * @return array|string Configuration du graphique en PHP ou en JSON
	 * @author Sylvain {20/02/2013}
	 */
	private function renderConfig($json = false)
	{
		if ($json === false)
			return array(
				'values'     => $this->getValues(),
				'timestamps' => $this->getTimestamps(),
				'milestones' => $this->getMilestones(),
				'graphConfs' => $this->getGraphOptions(),
				'tableConfs' => $this->getTableOptions(),
			);
		else
			return json_encode($this->renderConfig (false));
	}
	
	// #####################################################################################################
	// ###                                      FONCTIONS ABSTRAITES                                     ###
	// #####################################################################################################
	
	/**
	 * Instancie un objet timelineConf
	 * 
	 * Cet objet permet la configuration d'un graphique.
	 * <h2>Exemple d'utilisation</h2>
	 * <h3>Dans l'action</h3>
	 * @code{.php}
	 * 	$ts = array(strtotime('-3 month'), strtotime('-2 month'), strtotime('-1 month'), time());
	 * 	$v1 = array(10,                   -5,                   200,                  -3540.2);
	 * 	$v2 = array(-6,                   29,                   -26,                  1022357);
	 *	$ms = array(time() => 'Démonstration');
	 * 
	 * 	$graphConf = TimelineGraphOptions::create()
	 * 		->setScaleColumns(array(0,1))
	 * 		->setScaleType('allmaximized');
	 * 	
	 * 	$graph = TimelineGraph::create()
	 * 		->setTimestamps($ts)
	 * 		->setValues(array('serie1' => $v1, 'serie2' => $v2))
	 * 		->setGraphOptions($graphConf)
	 *		->setMilestones($ms);
	 * @endcode
	 * 
	 * <h3>Dans le template</h3>
	 * @code{.html}
	 * <div id="graph"></div>
	 * <div id="table"></div>
	 * 
	 * <?php $graph->load_google_javascripts("graph","table")->render() ?>
	 * @endcode
	 * 
	 * @return TimelineGraph 
	 * @author Sylvain {08/02/2013}
	 */
	public static function create()
	{
		return new TimelineGraph;
	}
}



class TimelineGraphException extends sfException{}
?>