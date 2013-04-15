<?php

class TimelineTableOptions extends TimelineOptions {
	
	
	// ########################################################################
	// ###                       VARIABLES D'INSTANCE                       ###
	// ########################################################################
	
	
	/**
	 * @copybrief TimelineTableOptions::setAllowHTML()
	 * @return boolean
	 */
	private $allowHTML = false;
	
	/**
	 * @copybrief TimelineTableOptions::setAlternatingRowStyle()
	 * @return boolean
	 */
	private $alternatingRowStyle = true;

	/**
	 * @copybrief TimelineTableOptions::setCssClassNames()
	 * @return STDClass
	 */
	private $cssClassNames = null;

	/**
	 * @copybrief TimelineTableOptions::setFirstRowNumber()
	 * @return int
	 */
	private $firstRowNumber = 1;
	
	/**
	 * @copybrief TimelineTableOptions::setHeight()
	 * @return string
	 */
	private $height = null;
	
	/**
	 * @copybrief TimelineTableOptions::setPage()
	 * @return string
	 */
	private $page = 'disable';
	
	/**
	 * @copybrief TimelineTableOptions::setPageSize()
	 * @return int
	 */
	private $pageSize = 10;
	
	/**
	 * @copybrief TimelineTableOptions::setRtlTable()
	 * @return boolean
	 */
	private $rtlTable = false;
	
	/**
	 * @copybrief TimelineTableOptions::setScrollLeftStartPosition()
	 * @return int
	 */
	private $scrollLeftStartPosition = 0;
	
	/**
	 * @copybrief TimelineTableOptions::setShowRowNumber()
	 * @return bolean
	 */
	private $showRowNumber = false;

	/**
	 * @copybrief TimelineTableOptions::setSort()
	 * @return string
	 */
	private $sort = 'enable';
	
	/**
	 * @copybrief TimelineTableOptions::setSortAscending()
	 * @return boolean
	 */
	private $sortAscending = true;
	
	/**
	 * @copybrief TimelineTableOptions::setSortColumn()
	 * @return int
	 */
	private $sortColumn = -1;
	
	/**
	 * @copybrief TimelineTableOptions::setStartPage()
	 * @return int
	 */
	private $startPage = 0;
	
	/**
	 * @copybrief TimelineTableOptions::setWidth()
	 * @return string
	 */
	private $width = null;
	
	// ----------------------------------------------- OPTIONS PERSONNELLES ---
	
	private $formatter = null;
	
	
	// ########################################################################
	// ###                           CONSTRUCTEUR                           ###
	// ########################################################################
	
	
	/**
	 * Le constructeur permet de définir des options par défaut.
	 * 
	 * @return TimelineGraphOptions
	 * @author Sylvain {10/03/2013}
	 */
	public function __construct()
	{
		$this->setPageSize(7); // même hauteur que le graphique
		$this->setFormatter(array('fractionDigits' => 0));
	}
	
	/**
	 * Configure les options du tableau de valeurs.
	 * 
	 * @return TimelineTableOptions
	 * @author Sylvain {10/03/2013}
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
			'showRowNumber',
			'sort',
			'sortAscending',
			'sortColumn',
			'startPage',
			'width',
			// ------------------------
			'formatter',
		);
	}
	
	
	// ########################################################################
	// ###                         ACCESSEURS (set)                         ###
	// ########################################################################

	
	/**
	 * If set to true, formatted values of cells that include HTML tags will be rendered as HTML. 
	 * If set to false, most custom formatters will not work properly.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr#Formatters
	 * 
	 * @param  boolean $allowHTML (default: false)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setAllowHTML($allowHTML) 
	{
		if (is_bool($allowHTML)) {
			$this->allowHTML = (bool) $allowHTML;
			$this->setModified('allowHTML');
		} else {
			throw new TimelineOptionException(array('allowHTML', "un booleen {true, false}", $allowHTML));
		}
		
		return $this;
	}

	/**
	 * Determines if alternating color style will be assigned to odd and even rows.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  boolean $alternatingRowStyle (default: true)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setAlternatingRowStyle($alternatingRowStyle) 
	{
		if (is_bool($alternatingRowStyle)) {
			$this->alternatingRowStyle = (bool) $alternatingRowStyle;
			$this->setModified('alternatingRowStyle');
		} else {
			throw new TimelineOptionException(array('alternatingRowStyle', "un booleen {true, false}", $alternatingRowStyle));
		}
		
		return $this;
	}

	/**
	 * An array in which each key name describes a table element, and the value is a string, defining a class to assign to that table element. 
	 * Use this property to assign custom CSS to specific elements of your table. 
	 * You must then define a CSS style for that class on your page. 
	 * 
	 * The following property names are supported:
	 * <ul>
	 *  <li><code>headerRow</code> : Assigns a class name to the table header row (<tr> element).</li>
	 *  <li><code>tableRow</code> : Assigns a class name to the non-header rows (<tr> elements).</li>
	 *  <li><code>oddTableRow</code> : Assigns a class name to odd table rows (<tr> elements). Note: the <code>alternatingRowStyle</code> option must be set to true.</li>
	 *  <li><code>selectedTableRow</code> : Assigns a class name to the selected table row (<tr> element).</li>
	 *  <li><code>hoverTableRow</code> : Assigns a class name to the hovered table row (<tr> element).</li>
	 *  <li><code>headerCell</code> : Assigns a class name to all cells in the header row (<td> element).</li>
	 *  <li><code>tableCell</code> : Assigns a class name to all non-header table cells (<td> element).</li>
	 *  <li><code>rowNumberCell</code> : Assigns a class name to the cells in the row number column (<td> element). Note: the <code>showRowNumber</code> option must be set to true.</li>
	 * </ul>
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  array $cssClassNames (default: null)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setCssClassNames($cssClassNames) 
	{
		$classNames  = new stdClass();
		$allowedKeys = array(
			'headerRow',
			'tableRow',
			'oddTableRow',
			'selectedTableRow',
			'hoverTableRow',
			'headerCell',
			'tableCell',
			'rowNumberCell'
		);
		
		if (is_array($cssClassNames)) {
			$keys = array_keys($cssClassNames);
			foreach ($keys as $key) {
				if (in_array($key, $allowedKeys)) {
					$classNames->$key = $cssClassNames[$key];
				} else {
					throw new TimelineOptionException(array(
						'cssClassNames',
						"Un tableau associatif dont les clefs peuvent prendre les valeurs suivantes : [" . implode(', ', $allowedKeys) . "]",
						$cssClassNames
					));
				}
			}
			
			if (array_key_exists('oddTableRow ', $cssClassNames) )
				$this->setAlternatingRowStyle(true);
			
			if (array_key_exists('rowNumberCell  ', $cssClassNames) )
				$this->setShowRowNumber(true);
			
			$this->cssClassNames = $cssClassNames;
			
		} else {
			throw new TimelineOptionException(array(
				'cssClassNames',
				"Un tableau associatif dont les clefs peuvent prendre les valeurs suivantes : [" . implode(', ', $allowedKeys) . "]",
				$cssClassNames
			));
		}
		
		return $this;
	}

	/**
	 * The row number for the first row in the dataTable. Used only if showRowNumber is true.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  int $firstRowNumber (default: 1)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setFirstRowNumber($firstRowNumber) 
	{
		if (is_numeric($firstRowNumber)) {
			$this->firstRowNumber = $firstRowNumber;
			$this->setModified('firstRowNumber');
		} else {
			throw new TimelineOptionException(array('firstRowNumber', "un entier", $firstRowNumber));
		}
		
		return $this;
	}

	/**
	 * Sets the height of the visualization's container element. 
	 * You can use standard HTML units (for example, '100px', '80em', '60'). 
	 * If no units are specified the number is assumed to be pixels. 
	 * If not specified, the browser will set the width automatically to fit the table; if set smaller than the size required by the table, will add a vertical scroll bar.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  string $height (default: automatic - browser choice)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setHeight($height) 
	{
		if (is_string($height)) {
			$this->height = $height;
			$this->setModified('height');
		} else {
			throw new TimelineOptionException(array('height', "un entier", $height));
		}
		
		return $this;
	}

	/**
	 * If and how to enable paging through the data. 
	 * 
	 * Choose one of the following string values:
	 * <ul>
	 *  <li><code>enable</code> : The table will include page-forward and page-back buttons. Clicking on these buttons will perform the paging operation and change the displayed page. You might want to also set the <code>pageSize</code> option.</li>
	 *  <li><code>disable</code> : Paging is not supported.</li>
	 *  <li><code>event</code> : The table will include page-forward and page-back buttons, but clicking them will trigger a 'page' event and will not change the displayed page. This option should be used when the code implements its own page turning logic. See the TableQueryWrapper example for an example of how to handle paging events manually.</li>
	 * </ul>
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * @see 
	 * 
	 * @param  string $page (default: disable)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setPage($page) 
	{
		if (is_string($page) && in_array($page, array('enable', 'disable', 'event'))) {
			$this->page = $page;
			$this->setModified('page');
		} else {
			throw new TimelineOptionException(array('page', "une des chaines de caracteres suivantes {'enable', 'disable', 'event'}", $page));
		}
		
		return $this;
	}

	/**
	 * The number of rows in each page, when paging is enable with the <code>page</code> option.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  int $pageSize (default: 10)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setPageSize($pageSize) 
	{
		if (is_numeric($pageSize)) {
			$this->pageSize = $pageSize;
			$this->setModified('pageSize');
		} else {
			throw new TimelineOptionException(array('pageSize', "un entier", $pageSize));
		}
		
		return $this;
	}

	/**
	 * 
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  boolean $rtlTable (default: false)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setRtlTable($rtlTable) 
	{
		if (is_bool($rtlTable)) {
			$this->rtlTable = (bool) $rtlTable;
			$this->setModified('rtlTable');
		} else {
			throw new TimelineOptionException(array('rtlTable', "un booleen {true, false}", $rtlTable));
		}
		
		return $this;
	}

	/**
	 * Sets the horizontal scrolling position, in pixels, if the table has horizontal scroll bars because you have set the <code>width</code> property.
	 * The table will open scrolled that many pixels past the leftmost column.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  int $scrollLeftStartPosition (default: 0)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setScrollLeftStartPosition($scrollLeftStartPosition) 
	{
		if (is_numeric($scrollLeftStartPosition)) {
			$this->scrollLeftStartPosition = $scrollLeftStartPosition;
			$this->setModified('scrollLeftStartPosition');
		} else {
			throw new TimelineOptionException(array('scrollLeftStartPosition', "un entier", $scrollLeftStartPosition));
		}
		
		return $this;
	}

	/**
	 * If set to true, show the row number as the first column of the table.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  boolean $showRowNumber (default: false)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setShowRowNumber($showRowNumber) 
	{
		if (is_bool($showRowNumber)) {
			$this->showRowNumber = (bool) $showRowNumber;
			$this->setModified('showRowNumber');
		} else {
			throw new TimelineOptionException(array('showRowNumber', "un booleen {true, false}", $showRowNumber));
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  string $sort (default: enable)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setSort($sort) 
	{
		if (is_string($sort) && in_array($sort, array('enable', 'disable', 'event'))) {
			$this->sort = $sort;
			$this->setModified('sort');
		} else {
			throw new TimelineOptionException(array('sort', "une des chaines de caracteres suivantes {'enable', 'disable', 'event'}", $sort));
		}
		
		return $this;
	}

	/**
	 * The order in which the initial sort column is sorted. 
	 * True for ascending, false for descending. 
	 * Ignored if <code>sortColumn</code> is not specified.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  boolean $sortAscending (default: true)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setSortAscending($sortAscending) 
	{
		if (is_bool($sortAscending)) {
			$this->sortAscending = (bool) $sortAscending;
			$this->setModified('sortAscending');
		} else {
			throw new TimelineOptionException(array('sortAscending', "un booleen {true, false}", $sortAscending));
		}
		
		return $this;
	}

	/**
	 * An index of a column in the data table, by which the table is initially sorted.
	 * The column will be marked with a small arrow indicating the sort order.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  int $sortColumn (default: -1)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setSortColumn($sortColumn) 
	{
		if (is_numeric($sortColumn)) {
			$this->sortColumn = (int) $sortColumn;
			$this->setModified('sortColumn');
		} else {
			throw new TimelineOptionException(array('sortColumn', "un entier", $sortColumn));
		}
		
		return $this;
	}

	/**
	 * The first table page to display.
	 * User only if <code>page</code> is in mode <em>enable</em>, <em>event</em>.
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  int $startPage (default: 0)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setStartPage($startPage) 
	{
		if (is_numeric($startPage)) {
			$this->startPage = (int) $startPage;
			$this->setModified('startPage');
		} else {
			throw new TimelineOptionException(array('startPage', "un entier", $startPage));
		}
		
		return $this;
		
	}

	/**
	 * 
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/gallery/table?hl=fr
	 * 
	 * @param  string $width (default: automatic - browser choice)
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {10/03/2013}
	 */
	public function setWidth($width) 
	{
		if (is_string($width)) {
			$this->width = $width;
			$this->setModified('width');
		} else {
			throw new TimelineOptionException(array('width', "un entier", $width));
		}
		
		return $this;
	}
	
	// ----------------------------------------------- OPTIONS PERSONNELLES ---

	/**
	 * Définit le formatter des nombres de la série.
	 * 
	 * Les clefs du tableau peuvent prendre les valeurs suivantes :
	 * <ul>
	 *  <li><code>decimalSymbol</code> : A character to use as the decimal marker. The default is a dot (.).</li>
	 *  <li><code>fractionDigits</code> : A number specifying how many digits to display after the decimal. The default is 2. If you specify more digits than the number contains, it will display zeros for the smaller values. Truncated values will be rounded (5 rounded up).</li>
	 *  <li><code>groupingSymbol</code> : A character to be used to group digits to the left of the decimal into sets of three. Default is a comma (,).</li>
	 *  <li><code>negativeColor</code> : The text color for negative values. No default value. Values can be any acceptable HTML color value, such as "red" or "#FF0000".</li>
	 *  <li><code>negativeParens</code> : A boolean, where true indicates that negative values should be surrounded by parentheses. Default is true.</li>
	 *  <li><code>pattern</code> : A format string. When provided, all other options are ignored, except <code>negativeColor</code>. The format string is a subset of the ICU pattern set. For instance, {pattern:'#,###%'} will result in output values "1,000%", "750%", and "50%" for values 10, 7.5, and 0.5.</li>
	 *  <li><code>prefix</code> : A string prefix for the value, for example "$".</li>
	 *  <li><code>suffix</code> : A string suffix for the value, for example "%".</li>
	 * </ul>
	 * 
	 * @see https://developers.google.com/chart/interactive/docs/reference#numberformatter
	 * @see http://icu-project.org/apiref/icu4c/classDecimalFormat.html#_details
	 * 
	 * @param  array $formatter Exemple <code>array('fractionDigits' => 2)</code>
	 * @return TimelineTableOptions <em>fluent interface</em>
	 * @throws TimelineOptionException
	 * @author Sylvain {15/04/2013}
	 */
	public function setFormatter($formatters) 
	{
		$allowedOptions = array('decimalSymbol', 'fractionDigits', 'groupingSymbol', 'negativeColor', 'negativeParens', 'pattern', 'prefix', 'suffix');
		
		if (is_array($formatters)) {
			$formatterNames = array_keys($formatters);
			foreach ($formatterNames as $name){
				if (!is_string($name) || !in_array($name, $allowedOptions)) {
					throw new TimelineOptionException(array('formatter', "un tableau avec une ou plusieurs des clefs suivantes : " . implode(', ', $allowedOptions), $formatters));
				}
			}
			$this->formatter = $formatters;
			$this->setModified('formatter');
		} else {
			throw new TimelineOptionException(array('formatter', "un tableau avec une ou plusieurs des clefs suivantes : " . implode(', ', $allowedOptions), $formatters));
		}
		
		return $this;
	}
}
?>
