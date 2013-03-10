<?php

class TimelineTableOptions extends TimelineOptions {
	
	
	// ########################################################################
	// ###                       VARIABLES D'INSTANCE                       ###
	// ########################################################################
	
	
	/**
	 * @copybrief TimelineGraphOptions::setAllowHTML()
	 * @return boolean
	 */
	private $allowHTML = false;
	
	/**
	 *
	 * @return boolean
	 */
	private $alternatingRowStyle = true;

	/**
	 * 
	 * @return STDClass
	 */
	private $cssClassNames = null;

	/**
	 * 
	 * @return int
	 */
	private $firstRowNumber = 1;
	
	/**
	 *
	 * @return string
	 */
	private $height = null;
	
	/**
	 *
	 * @return string
	 */
	private $page = 'disable';
	
	/**
	 *
	 * @return int
	 */
	private $pageSize = 10;
	
	/**
	 *
	 * @return boolean
	 */
	private $rtlTable = false;
	
	/**
	 *
	 * @return int
	 */
	private $scrollLeftStartPosition = 0;

	/**
	 *
	 * @return string
	 */
	private $sort = 'enable';
	
	/**
	 *
	 * @return boolean
	 */
	private $sortAscending = true;
	
	/**
	 *
	 * @return int
	 */
	private $sortColumn = -1;
	
	/**
	 *
	 * @return int
	 */
	private $startPage = 0;
	
	/**
	 *
	 * @return string
	 */
	private $width = null;
	
	
	// ########################################################################
	// ###                           CONSTRUCTEUR                           ###
	// ########################################################################
	
	
	/**
	 * Le constructeur permet de définir des options par défaut.
	 * 
	 * <ul>
	 *  <li>Affichage des annotations : <b>oui</b></li>
	 *  <li>Affichage du sélecteur d'échelle (le truc bizarre en dessous) : <b>non</b></li>
	 *  <li>Affichage des valeurs exactes : <b>oui</b></li>
	 *  <li>Zone de zoom : <b>1 an à partir de maintenant</b></li>
	 * </ul>
	 * 
	 * @return TimelineGraphOptions
	 * @author Sylvain {20/02/2013}
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * Configure les options du graphique.
	 * 
	 * Des options par défaut sont déjà prédéfinies (mais être être écrasées) :
	 * <ul>
	 *  <li>Affichage des annotations : <b>oui</b></li>
	 *  <li>Affichage du sélecteur d'échelle (le truc bizarre en dessous) : <b>non</b></li>
	 *  <li>Affichage des valeurs exactes : <b>oui</b></li>
	 *  <li>Zone de zoom : <b>1 an à partir de maintenant</b></li>
	 * </ul>
	 * 
	 * @return TimelineGraphOptions
	 * @author Sylvain
	 */
	public static function create() 
	{ 
		return new TimelineTableOptions(); 
	}
	
	/**
	 * @copydoc TimelineOptions::toArray()
	 */
	public function toArray()
	{
		$options  = array();
		$modified = $this->getModified();
		
		foreach ($modified as $option) { 
			$options[$option] = $this->$option;
		}
		
		return $options;
	}
	
	
	// ########################################################################
	// ###                        FONCTIONS PRIVEES                         ###
	// ########################################################################
	
	
	/**
	 * @copydoc TimelineOptions::allowedOptions()
	 */
	protected function allowedOptions() {
		return array(
			'allowHTML',
			'alternatingRowStyle',
			'cssClassNames',
			'firstRowNumber',
			'height',
			'page',
			'pageSize',
			'rtlTable',
			'scrollLeftStartPosition',
			'sort',
			'sortAscending',
			'sortColumn',
			'startPage',
			'width'
		);
	}
	
	
	// ########################################################################
	// ###                         ACCESSEURS (set)                         ###
	// ########################################################################

	public function setAllowHTML($allowHTML) 
	{
		$this->allowHTML = $allowHTML;
	}

	public function setAlternatingRowStyle($alternatingRowStyle) 
	{
		$this->alternatingRowStyle = $alternatingRowStyle;
	}

	public function setCssClassNames($cssClassNames) 
	{
		$this->cssClassNames = $cssClassNames;
	}

	public function setFirstRowNumber($firstRowNumber) 
	{
		$this->firstRowNumber = $firstRowNumber;
	}

	public function setHeight($height) 
	{
		$this->height = $height;
	}

	public function setPage($page) 
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize) 
	{
		$this->pageSize = $pageSize;
	}

	public function setRtlTable($rtlTable) 
	{
		$this->rtlTable = $rtlTable;
	}

	public function setScrollLeftStartPosition($scrollLeftStartPosition) 
	{
		$this->scrollLeftStartPosition = $scrollLeftStartPosition;
	}

	public function setSort($sort) 
	{
		$this->sort = $sort;
	}

	public function setSortAscending($sortAscending) 
	{
		$this->sortAscending = $sortAscending;
	}

	public function setSortColumn($sortColumn) 
	{
		$this->sortColumn = $sortColumn;
	}

	public function setStartPage($startPage) 
	{
		$this->startPage = $startPage;
	}

	public function setWidth($width) 
	{
		$this->width = $width;
	}
}
?>
