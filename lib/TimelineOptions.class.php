<?php

abstract class TimelineOptions {
	
	
	// ########################################################################
	// ###                       VARIABLES D'INSTANCE                       ###
	// ########################################################################
	
	
	/**
	 * Contient la liste des options modifiées
	 * @return array
	 */
	protected $modified = array();
	
	
	// ########################################################################
	// ###                       FONCTIONS PUBLIQUES                        ###
	// ########################################################################
	
	/**
	 * Supprime une option configurée.
	 * Il suffit pour cela de l'enlever du tableau qui enregistre les option configurées (c'est ce tableau qui sert de base à toArray()).
	 * 
	 * @param  string $option Nom de l'option
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function removeOption($option)
	{
		$this->checkOption($option);
		if (array_search($option, $this->getModified()) !== false){
			unset($this->modified[array_search($option, $this->getModified())]);
		}
		
		return $this;
	}
	
	/**
	 * Indique si l'option donnée a été configurée ou non.
	 * 
	 * Si une <code>$valeur</code> est donnée, on vérifie en plus que l'option a bien la valeur donnée. 
	 * Pour faire cette comparaison, on utilise l'opérateur strict <code>===</code>.
	 * 
	 * @param  string $option Nom de l'option
	 * @return boolean
	 * @author Sylvain {20/02/2013}
	 */
	public function has($option, $valeur = null)
	{
		$this->checkOption($option);
		$modified = (array_search($option, $this->getModified()) !== false);
		$correcte = (isset($valeur)) ? $this->$option === $valeur : true;
		
		return $modified && $correcte;
	}
	
	
	// ########################################################################
	// ###                         FONCTIONS PRIVEES                        ###
	// ########################################################################
	
	
	/**
	 * Vérifie que l'option donnée en paramètre est valide.
	 * 
	 * @param  string $option
	 * @throws TimelineGraphException si l'option donnée est invalide
	 * @author Sylvain {20/02/2013}
	 */
	protected function checkOption($option)
	{
		if (!in_array($option, $this->allowedOptions())){
			throw new TimelineGraphException(sprintf("L'option [%s] n'est pas reconnue par Google", $option));
		}
	}
	
	/**
	 * Indique qu'une option valide a été modifiée et enregistre cette option dans TimelineGraphOptions::$modified.
	 * 
	 * @param  string $option Nom de l'option modifiée.
	 * @author Sylvain {20/02/2013}
	 */
	protected function setModified($option)
	{
		$this->checkOption($option);
		if (array_search($option, $this->getModified()) === false){
			$this->modified[] = $option;
		}
	}
	
	/**
	 * Renvoie la liste des options modifiées lors de la configuration.
	 * 
	 * @return array
	 * @author Sylvain {20/02/2013}
	 */
	protected function getModified() 
	{ 
		return $this->modified;
	}
	
	protected function throw_exception($optionName, $expected, $given)
	{
		if     (is_null($given))	$givenClass = "null";
		elseif (is_numeric($given))	$givenClass = "int";
		elseif (is_string($given))	$givenClass = "string";
		elseif (is_bool($given))	$givenClass = "boolean";
		elseif (is_array($given))	$givenClass = "array";
		elseif (is_object($given))	$givenClass = get_class($given);
		
		throw new TimelineGraphException(
					sprintf("L'option [%s] doit être %s et non [(%s) %s].",
							$optionName,
							$expected,
							$givenClass,
							$given
					)
			);
	}
	
	
	// ########################################################################
	// ###                       FONCTIONS ABSTRAITES                       ###
	// ########################################################################
	
	/**
	 * Renvoie la liste des options autorisées et reconnues par Google.
	 * 
	 * @return array
	 * @author Sylvain {20/02/2013}
	 */
	abstract protected function allowedOptions();
	
	/**
	 * Renvoie le résultat de la configuration.
	 * Il s'agit d'un tableau associatif ayant pour clef le nom d'un option, et pour valeur la donnée configurée.
	 * 
	 * @return array
	 * @author Sylvain {20/02/2013}
	 */
	abstract public function toArray();
}
?>
