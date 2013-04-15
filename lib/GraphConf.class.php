<?php

abstract class GraphConf{
	
	// #####################################################################################################
	// ###                                           CONSTANTES                                          ###
	// #####################################################################################################
	
	protected $values = array();
	
	protected $graphOptions = array();
	
	protected $tableOptions = array();
	
	protected $graphDivId = null;
	
	protected $tableDivId = null;
	
	// #####################################################################################################
	// ###                                           ACCESSEURS                                          ###
	// #####################################################################################################
	
	/**
	 * Renvoie le tableau de valeurs pour une série (<code>$serie</code>) ou pour toutes les séries.
	 * 
	 * @param  type $serie [FACULTATIF] Nom de la série à renvoyer. Si ce paramètre n'est pas définit (<code>null</code>), on renvoie toutes les séries.
	 * @return array
	 * @throws TimelineGraphException si le nom de la série demandée n'existe pas.
	 * @author Sylvain
	 */
	public function getValues($serie = null)
	{ 
		if (isset($serie) && is_string($serie)) {
			if (array_key_exists($serie, $this->values)) {
				return $this->values[$serie];
			} else {
				throw new TimelineGraphException(sprintf(
						"La série [%s] n'existe pas (%s). ",
						$serie,
						implode(', ', array_keys($this->values))
				));
			}
		} else {
			return $this->values; 
		}
	}
	
	/**
	 * Définit le tableau de valeurs du graphique après en avoir vérifier le format.
	 * 
	 * Un tableau de valeurs valide ressemble à :
	 * <code><pre>
	 * array(
	 *   &nbsp; "Libellé de la série 1" => array(0,1,2),
	 *   &nbsp; "Libellé de la série 2" => array(5,4,3),
	 * )
	 * </pre></code>
	 * 
	 * @param  array $values tableau de valeurs du graphique
	 * @return GraphConf <em>fluent interface</em>
	 * @author Sylvain
	 */
	public function setValues(Array $values) 
	{
		$this->checkValues($values);
		$this->values = $values;
		
		return $this;
	}
	
	
	protected function hasGraphOptions() { return count($this->getGraphOptions()) > 0; }
	protected function getGraphOptions() { return $this->graphOptions; }
	public    function setGraphOptions($graphOptions) { $this->graphOptions = $graphOptions; return $this; }
	
	protected function hasTableOptions() { return count($this->getTableOptions()) > 0; }
	protected function getTableOptions() { return $this->tableOptions; }
	public    function setTableOptions($tableOptions)  { $this->tableOptions = $tableOptions; return $this; }
	
	protected function setGraphDivId($id) { $this->graphDivId = $id; }
	protected function getGraphDivId()    { return $this->graphDivId; }
	protected function hasGraphDivId()    { return isset($this->graphDivId); }
	
	protected function setTableDivId($id) { $this->tableDivId = $id; }
	protected function getTableDivId()    { return $this->tableDivId; }
	protected function hasTableDivId()    { return isset($this->tableDivId); }	
	
	
	// #####################################################################################################
	// ###                                       FONCTIONS PRIVEES                                       ###
	// #####################################################################################################
	
	/**
	 * Vérifie le formatage du tableau de valeurs.
	 * 
	 * Un tableau de valeurs valide ressemble à :
	 * <code><pre>
	 * array(
	 *   &nbsp; "Libellé de la série 1" => array(0,1,2),
	 *   &nbsp; "Libellé de la série 2" => array(5,4,3),
	 * )
	 * </pre></code>
	 * 
	 * @todo   A vérifier si le nombre de valeurs de chaque série doit impérativement être identique.
	 * @param  array $series Tableau de valeurs à contrôler
	 * @throws TimelineGraphException si le format n'est pas correct.
	 */
	private function checkValues($series)
	{
		if (!is_array($series))
			throw new TimelineGraphException("Les valeurs du graphiques doivent être envoyées dans un tableau.");
		
		foreach ($series as $name => $values){
			if (!is_string($name))
				throw new TimelineGraphException("Les clefs du tableau de valeurs sont les noms des séries du graphique.");
			
			if (!is_array($values))
				throw new TimelineGraphException("Les valeurs du tableau de valeurs sont les noms des séries du graphique.");
		}
	}
}

?>
