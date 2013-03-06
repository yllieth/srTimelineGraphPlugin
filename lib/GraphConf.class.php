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
	
	public function setValues(Array $values = array()) 
	{
		$this->checkValues($values);
		$this->values = $values;
		
		return $this;
	}
	
	
	protected function hasGraphOptions() { return count($this->getGraphOptions()) > 0; }
	protected function getGraphOptions() { return $this->graphOptions; }
	public    function setGraphOptions($graphOptions) { $this->graphOptions = $graphOptions; return $this; }
	
	protected function getTableOptions() { return $this->tableOptions; }
	public    function setTableOptions(Array $tableOptions = array())  { $this->tableOptions = $tableOptions; return $this; }
	
	protected function setGraphDivId($id) { $this->graphDivId = $id; }
	protected function getGraphDivId()    { return $this->graphDivId; }
	protected function hasGraphDivId()    { return isset($this->graphDivId); }
	
	protected function setTableDivId($id) { $this->tableDivId = $id; }
	protected function getTableDivId()    { return $this->tableDivId; }
	protected function hasTableDivId()    { return isset($this->tableDivId); }	
	
	
	// #####################################################################################################
	// ###                                       FONCTIONS PRIVEES                                       ###
	// #####################################################################################################
	
	
	private function checkValues($array)
	{
		
	}
}

?>
