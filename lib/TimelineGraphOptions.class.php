<?php

class TimelineGraphOptions extends TimelineOptions {
	
	
	// ########################################################################
	// ###                       VARIABLES D'INSTANCE                       ###
	// ########################################################################
	
	
	/**
	 * @copybrief TimelineGraphOptions::setAllowHTML()
	 * @return boolean
	 */
	private $allowHTML = false;
	
	/**
	 * @copybrief TimelineGraphOptions::setAllowRedraw()
	 * @return boolean
	 */
	private $allowRedraw = false;
	
	/**
	 * @copybrief TimelineGraphOptions::setAllValuesSuffix()
	 * @return string
	 */
	private $allValuesSuffix = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setAnnotationsWidth()
	 * @return int
	 */
	private $annotationsWidth = 25;
	
	/**
	 * @copybrief TimelineGraphOptions::setColors()
	 * @return array
	 */
	private $colors = array();
	
	/**
	 * @copybrief TimelineGraphOptions::setDateFormat()
	 * @return string
	 */
	private $dateFormat = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayAnnotations()
	 * @return boolean
	 */
	private $displayAnnotations = false;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayAnnotationsFilter()
	 * @return boolean
	 */
	private $displayAnnotationsFilter = false;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayDateBarSeparator()
	 * @return boolean
	 */
	private $displayDateBarSeparator = true;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayExactValues()
	 * @return boolean
	 */
	private $displayExactValues = false;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayLegendDots()
	 * @return boolean
	 */
	private $displayLegendDots = true;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayLegendValues()
	 * @return boolean
	 */
	private $displayLegendValues = true;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayRangeSelector()
	 * @return boolean
	 */
	private $displayRangeSelector = true;
	
	/**
	 * @copybrief TimelineGraphOptions::setDisplayZoomButtons()
	 * @return boolean
	 */
	private $displayZoomButtons = true;
	
	/**
	 * @copybrief TimelineGraphOptions::setOpacity()
	 * @return int
	 */
	private $fill = 0;
	
	/**
	 * @copybrief TimelineGraphOptions::setHighlightDot()
	 * @return string
	 */
	private $highlightDot = 'nearest';
	
	/**
	 * @copybrief TimelineGraphOptions::setLegendPosition()
	 * @return string
	 */
	private $legendPosition = 'sameRow';
	
	/**
	 * @copybrief TimelineGraphOptions::setMax()
	 * @return int
	 */
	private $max = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setMin()
	 * @return int
	 */
	private $min = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setNumberFormats()
	 * @return string
	 */
	private $numberFormats = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setScaleColumns()
	 * @return array
	 */
	private $scaleColumns = array();
	
	/**
	 * @copybrief TimelineGraphOptions::setScaleType()
	 * @return string
	 */
	private $scaleType = 'fixed';
	
	/**
	 * @copybrief TimelineGraphOptions::setThickness()
	 * @return int
	 */
	private $thickness = 0;
	
	/**
	 * @copybrief TimelineGraphOptions::setWmode()
	 * @return string
	 */
	private $wmode = 'window';
	
	/**
	 * @copybrief TimelineGraphOptions::setZoomEndTime()
	 * @return int
	 */
	private $zoomEndTime = null;
	
	/**
	 * @copybrief TimelineGraphOptions::setZoomStartTime()
	 * @return int
	 */
	private $zoomStartTime = null;
	
	
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
		$this->setDisplayAnnotations(true);
		$this->setDisplayRangeSelector(false);
		$this->setDisplayExactValues(true);
		$this->setZoomEndTime(time());
		$this->setZoomStartTime(strtotime('-1 year'));
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
	public static function create() { return new TimelineGraphOptions(); }
	
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
	protected function allowedOptions()
	{
		return array(
			'allowHTML',
			'allowRedraw',
			'allValuesSuffix',
			'annotationsWidth',
			'colors',
			'dateFormat',
			'displayAnnotations',
			'displayAnnotationsFilter',
			'displayDateBarSeparator',
			'displayExactValues',
			'displayLegendDots',
			'displayLegendValues',
			'displayRangeSelector',
			'displayZoomButtons',
			'fill',
			'highlightDot',
			'legendPosition',
			'max',
			'min',
			'numberFormats',
			'scaleColumns',
			'scaleType',
			'thickness',
			'wmode',
			'zoomEndTime',
			'zoomStartTime',
		);
	}
	
	// ########################################################################
	// ###                         ACCESSEURS (set)                         ###
	// ########################################################################
	
		
	/**
	 * If set to true, any annotation text that includes HTML tags will be rendered as HTML.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean $allow_html
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setAllowHTML($allow_html)
	{
		if (is_bool($allow_html)) {
			$this->allowHTML = (bool) $allow_html;
			$this->setModified('allowHTML');
		} else {
			throw new TimelineOptionException(array('allowHTML', "un booleen {true, false}", $allow_html));
		}
		
		return $this;
	}
	
	/**
	 * Enables a more efficient redrawing technique for the second and later calls to draw() on this visualization. 
	 * It only redraws the chart area. To use this option, you must fulfill the following requirements:
	 * 
	 * <ul>
	 *  <li><code>allowRedraw</code> must be true</li>
	 *  <li><code>displayAnnotations</code> must be false (that is, you cannot show annotations)</li>
	 *  <li>you must pass in the same options and values (except for the <code>allowRedraw</code> and <code>displayAnnotations</code>) as in your first call to draw().</li>
	 * </ul>
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean $allow_redraw
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setAllowRedraw($allow_redraw)
	{
		if (is_bool($allow_redraw)) {
			$this->allowRedraw = (bool) $allow_redraw;
			$this->setModified('allowRedraw');
		} else {
			throw new TimelineOptionException(array('allowRedraw', "un booleen {true, false}", $allow_redraw));
		}
		
		return $this;
	}
	
	/**
	 * A suffix to be added to all values in the scales and the legend.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  string $suffix
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setAllValuesSuffix($suffixe)
	{
		if (is_string($suffixe)) {
			$this->allValuesSuffix = $suffixe;
			$this->setModified('allValuesSuffix');
		} else {
			throw new TimelineOptionException(array('allValuesSuffix', "une chaine de carateres", $suffixe));
		}
		
		return $this;
	}
	
	/**
	 * The width (in percent) of the annotations area, out of the entire chart area. 
	 * Must be a number in the range 5-80.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $pourcentage
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setAnnotationsWidth($pourcentage)
	{
		if (is_numeric($pourcentage) && $pourcentage >= 5 && $pourcentage <= 80) {
			$this->annotationsWidth = (int) $pourcentage;
			$this->setModified('annotationsWidth');
		} else {
			throw new TimelineOptionException(array('annotationsWidth', "un entier [5 .. 80]", $pourcentage));
		}
		
		return $this;
	}
	
	/**
	 * The colors to use for the chart lines and labels. An array of strings. 
	 * Each element is a string in a valid HTML color format. For example 'red' or '#00cc00'.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  array $liste_de_couleurs
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setColors(Array $liste_de_couleurs)
	{
		if (is_array($liste_de_couleurs)) {
			$this->colors = $liste_de_couleurs;
			$this->setModified('colors');
		} else {
			throw new TimelineOptionException(array('colors', "un tableau contenant des noms de couleurs HTML valides", $liste_de_couleurs));
		}
		
		return $this;
	}
	
	/**
	 * The format used to display the date information in the top right corner. 
	 * The format of this field is as specified by the java SimpleDateFormat class.
	 * Either 'MMMM dd, yyyy' or 'HH:mm MMMM dd, yyyy', depending on the type of the first column (date, or datetime, respectively).
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * @see    http://icu-project.org/apiref/icu4j/com/ibm/icu/text/SimpleDateFormat.html
	 * 
	 * @param  string $format
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDateFormat($format)
	{
		if (is_string($format)) {
			$this->dateFormat = $format;
			$this->setModified('dateFormat');
		} else {
			throw new TimelineOptionException(array('dateFormat', "un tableau contenant des noms de couleurs HTML valides", $format));
		}
		
		return $this;
	}
	
	/**
	 * If set to true, the chart will show annotations on top of selected values. 
	 * When this option is set to true, after every numeric column, two optional annotation string columns can be added, one for the annotation title and one for the annotation text.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayAnnotations
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayAnnotations($displayAnnotations)
	{
		if (is_bool($displayAnnotations)) {
			$this->displayAnnotations = $displayAnnotations;
			$this->setModified('displayAnnotations');
		} else {
			throw new TimelineOptionException(array('displayAnnotations', "un booleen {true, false}", $displayAnnotations));
		}
		
		return $this;
	}
	
	/**
	 * If set to true, the chart will display a filter contol to filter annotations. 
	 * Use this option when there are many annotations.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayAnnotationsFilter
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayAnnotationsFilter($displayAnnotationsFilter)
	{
		if (is_bool($displayAnnotationsFilter)) {
			$this->displayAnnotationsFilter = $displayAnnotationsFilter;
			$this->setModified('displayAnnotationsFilter');
		} else {
			throw new TimelineOptionException(array('displayAnnotationsFilter', "un booleen {true, false}", $displayAnnotationsFilter));
		}
		
		return $this;
	}
	
	/**
	 * Whether to display a small bar separator ( | ) between the series values and the date in the legend, where true means yes.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayDateBarSeparator
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayDateBarSeparator($displayDateBarSeparator)
	{
		if (is_bool($displayDateBarSeparator)) {
			$this->displayDateBarSeparator = $displayDateBarSeparator;
			$this->setModified('displayDateBarSeparator');
		} else {
			throw new TimelineOptionException(array('displayDateBarSeparator', "un booleen {true, false}", $displayDateBarSeparator));
		}
		
		return $this;
	}
	
	/**
	 * Whether to display a shortened, rounded version of the values on the top of the graph, to save space; false indicates that it may. 
	 * For example, if set to false, 56123.45 might be displayed as 56.12k.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayExactValues
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayExactValues($displayExactValues)
	{
		if (is_bool($displayExactValues)) {
			$this->displayExactValues = $displayExactValues;
			$this->setModified('displayExactValues');
		} else {
			throw new TimelineOptionException(array('displayExactValues', "un booleen {true, false}", $displayExactValues));
		}
		
		return $this;
	}
	
	/**
	 * Whether to display dots next to the values in the legend text, where true means yes.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayLegendDots
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayLegendDots($displayLegendDots)
	{
		if (is_bool($displayLegendDots)) {
			$this->displayLegendDots = $displayLegendDots;
			$this->setModified('displayLegendDots');
		} else {
			throw new TimelineOptionException(array('displayLegendDots', "un booleen {true, false}", $displayLegendDots));
		}
		
		return $this;
	}
	
	/**
	 * Whether to display the highlighted values in the legend, where true means yes.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayLegendValues
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayLegendValues($displayLegendValues)
	{
		if (is_bool($displayLegendValues)) {
			$this->displayLegendValues = $displayLegendValues;
			$this->setModified('displayLegendValues');
		} else {
			throw new TimelineOptionException(array('displayLegendValues', "un booleen {true, false}", $displayLegendValues));
		}
		
		return $this;
	}
	
	/**
	 * Whether to show the zoom range selection area (the area at the bottom of the chart), where false means no
	 * The outline in the zoom selector is a log scale version of the last series in the chart, scaled to fit the height of the zoom selector.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayRangeSelector
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayRangeSelector($displayRangeSelector)
	{
		if (is_bool($displayRangeSelector)) {
			$this->displayRangeSelector = $displayRangeSelector;
			$this->setModified('displayRangeSelector');
		} else {
			throw new TimelineOptionException(array('displayRangeSelector', "un booleen {true, false}", $displayRangeSelector));
		}
		
		return $this;
	}
	
	/**
	 * Whether to show the zoom links ("1d 5d 1m" and so on), where false means no.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  boolean displayZoomButtons
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setDisplayZoomButtons($displayZoomButtons)
	{
		if (is_bool($displayZoomButtons)) {
			$this->displayZoomButtons = $displayZoomButtons;
			$this->setModified('displayZoomButtons');
		} else {
			throw new TimelineOptionException(array('displayZoomButtons', "un booleen {true, false}", $displayZoomButtons));
		}
		
		return $this;
	}
	
	/**
	 * A number from 0—100 (inclusive) specifying the alpha of the fill below each line in the line graph. 
	 * 100 means 100% opaque fill, 0 means no fill at all. 
	 * The fill color is the same color as the line above it.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $pourcentage
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setFill($pourcentage)
	{
		if (is_numeric($pourcentage) && $pourcentage >= 0 && $pourcentage <= 100) {
			$this->fill = (int) $pourcentage;
			$this->setModified('fill');
		} else {
			throw new TimelineOptionException(array('fill', "un entier [0 .. 100]", $pourcentage));
		}
		
		return $this;
	}
	
	/**
	 * Which dot on the series to highlight, and corresponding values to show in the legend. 
	 * Select from one of these values:
	 * - 'nearest' - The values closest along the X axis to the mouse.
	 * - 'last' - The next set of values to the left of the mouse.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  string $highlightDot {"nearest", "last"}
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setHighlightDot($highlightDot)
	{
		if (is_string($highlightDot) && in_array($highlightDot, array('nearest', 'last'))) {
			$this->highlightDot = $highlightDot;
			$this->setModified('highlightDot');
		} else {
			throw new TimelineOptionException(array('highlightDot', "une des chaines de caracteres suivantes {'nearest', 'last'}", $highlightDot));
		}
		
		return $this;
	}
	
	/**
	 * Whether to put the colored legend on the same row with the zoom buttons and the date ('sameRow'), or on a new row ('newRow').
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  string $position {"sameRow", "newRow"}
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setLegendPosition($position)
	{
		if (is_string($position) && in_array($position, array('sameRow', 'newRow'))) {
			$this->legendPosition = $position;
			$this->setModified('legendPosition');
		} else {
			throw new TimelineOptionException(array('legendPosition', "une des chaines de caracteres suivantes {'sameRow', 'newRow'}", $position));
		}
		
		return $this;
	}
	
	/**
	 * The maximum value to show on the Y axis. 
	 * If the maximum data point exceeds this value, this setting will be ignored, and the chart will be adjusted to show the next major tick mark above the maximum data point. 
	 * This will take precedence over the Y axis maximum determined by <code>scaleType</code>.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $max
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setMax($max)
	{
		if (is_numeric($max)) {
			$this->max = (int) $max;
			$this->setModified('max');
		} else {
			throw new TimelineOptionException(array('max', "un entier", $max));
		}
		
		return $this;
	}
	
	/**
	 * The minimum value to show on the Y axis. 
	 * If the minimum data point is less than this value, this setting will be ignored, and the chart will be adjusted to show the next major tick mark below the minimum data point. 
	 * This will take precedence over the Y axis minimum determined by <code>scaleType</code>.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $min
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setMin($min)
	{
		if (is_numeric($min)) {
			$this->min = (int) $min;
			$this->setModified('min');
		} else {
			throw new TimelineOptionException(array('min', "un entier", $min));
		}
		
		return $this;
	}
	
	/**
	 * Specifies the number format patterns to be used to format the values at the top of the graph.
	 * The patterns should be in the format as specified by the java DecimalFormat class.
	 * - If not specified, the default format pattern is used.
	 * - If a single string pattern is specified, it is used for all of the values.
	 * - If a map is specified, the keys are (zero-based) indexes of series, and the values are the patterns to be used to format the specified series.
	 * You are not required to include a format for every series on the chart; any unspecified series will use the default format.
	 * 
	 * If this option is specified, the <code>displayExactValues</code> option is ignored.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * @see    http://icu-project.org/apiref/icu4j/com/ibm/icu/text/DecimalFormat.html
	 * 
	 * @param  string $format
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setNumberFormats($format)
	{
		if (is_string($format)) {
			$this->numberFormats = $format;
			$this->setModified('numberFormats');
		} else {
			throw new TimelineOptionException(array('numberFormats', "un tableau contenant des noms de couleurs HTML valides", $format));
		}
		
		return $this;
	}
	
	/**
	 * Specifies which values to show on the Y axis tick marks in the graph. 
	 * The default is to have a single scale on the right side, which applies to both series; but you can have different sides of the graph scaled to different series values.
	 * 
	 * This option takes an array of zero to three numbers specifying the (zero-based) index of the series to use as the scale value. 
	 * Where these values are shown depends on how many values you include in your array:
	 * <ul>
	 *  <li>If you specify an empty array, the chart will not show Y values next to the tick marks.</li>
	 *  <li>If you specify one value, the scale of the indicated series will be displayed on the right side of the chart only.</li>
	 *  <li>If you specify two values, a the scale for the second series will be added to the right of the chart.</li>
	 *  <li>If you specify three values, a scale for the third series will be added to the middle of the chart.</li>
	 *  <li>Any values after the third in the array will be ignored.</li>
	 * </ul>
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  array $colonnes
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setScaleColumns(Array $colonnes)
	{
		if (is_array($colonnes) && count($colonnes) <= 3) {
			$this->scaleColumns = $colonnes;
			$this->setModified('scaleColumns');
		} else {
			throw new TimelineOptionException(array('scaleColumns', "un tableau contenant les index des courbes à placer (max 3)", $colonnes));
		}
		
		return $this;
	}
	
	/**
	 * Sets the maximum and minimum values shown on the Y axis. 
	 * The following options are available:
	 * <ul>
	 *  <li><em>maximized</em>The Y axis will span the minimum to the maximum values of the series. If you have more than one series, use allmaximized.</li>
	 *  <li>
	 *   <em>fixed</em>The Y axis varies, depending on the data values values:
	 *   <ul>
	 *    <li>If all values are >=0, the Y axis will span from zero to the maximum data value.</li>
	 *    <li>If all values are <=0, the Y axis will span from zero to the minimum data value.</li>
	 *    <li>If values are both positive and negative, the Y axis will range from the series maximum to the series minimum.</li>
	 *   </ul>
	 *  </li>
	 *  <li><em>allmaximized</em>Same as 'maximized,' but used when multiple scales are displayed. Both charts will be maximized within the same scale, which means that one will be misrepresented against the Y axis, but hovering over each series will display it's true value.</li>
	 *  <li><em>allfixed</em>Same as 'fixed,' but used when multiple scales are displayed. This setting adjusts each scale to the series to which it applies (use this in conjunction with scaleColumns). (<b>ideal for multiple series</b>)</li>
	 * </ul>
	 * 
	 * If you specify the min and/or max options, they will take precedence over the minimum and maximum values determined by your scale type.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  string $scaleType {'maximized', 'fixed', 'allmaximized', 'allfixed'}
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setScaleType($scaleType)
	{
		if (is_string($scaleType) && in_array($scaleType, array('maximized', 'fixed', 'allmaximized', 'allfixed'))) {
			$this->scaleType = $scaleType;
			$this->setModified('scaleType');
		} else {
			throw new TimelineOptionException(array('scaleType', 'une des chaines de caracteres suivantes {"maximized", "fixed", "allmaximized", "allfixed"}', $scaleType));
		}
		
		return $this;
	}
	
	/**
	 * A number from 0—10 (inclusive) specifying the thickness of the lines, where 0 is the thinnest.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $epaisseur Compris entre 0 et 10
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setThickness($epaisseur)
	{
		if (is_numeric($epaisseur) && $epaisseur >= 0 && $epaisseur <= 10) {
			$this->thickness = (int) $epaisseur;
			$this->setModified('thickness');
		} else {
			throw new TimelineOptionException(array('thickness', "un entier [0 .. 10]", $epaisseur));
		}
		
		return $this;
	}
	
	/**
	 * The Window Mode (wmode) parameter for the Flash chart. 
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  string $wmode {"opaque", "window", "transparent"}
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setWmode($wmode)
	{
		if (is_string($wmode) && in_array($wmode, array("opaque", "window", "transparent"))) {
			$this->wmode = $wmode;
			$this->setModified('wmode');
		} else {
			throw new TimelineOptionException(array('wmode', 'une des chaines de caracteres suivantes {"opaque", "window", "transparent"}', $wmode));
		}
		
		return $this;
	}
	
	/**
	 * Sets the end date/time of the selected zoom range.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $timestamp
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setZoomEndTime($unix_timestamp)
	{
		if (is_numeric($unix_timestamp)) {
			$this->zoomEndTime = (int) $unix_timestamp;
			$this->setModified('zoomEndTime');
		} else {
			throw new TimelineOptionException(array('zoomEndTime', 'un entier (timestamp UNIX)', $unix_timestamp));
		}
		
		return $this;
	}
	
	/**
	 * Sets the start date/time of the selected zoom range.
	 * 
	 * @see    https://developers.google.com/chart/interactive/docs/gallery/annotatedtimeline?hl=fr
	 * 
	 * @param  int $timestamp
	 * @throws TimelineOptionException
	 * @return TimelineGraphOptions <em>fluent interface</em>
	 * @author Sylvain {20/02/2013}
	 */
	public function setZoomStartTime($unix_timestamp)
	{
		if (is_numeric($unix_timestamp)) {
			$this->zoomStartTime = (int) $unix_timestamp;
			$this->setModified('zoomStartTime');
		} else {
			throw new TimelineOptionException(array('zoomStartTime', 'un entier (timestamp UNIX)', $unix_timestamp));
		}
		
		return $this;
	}
}
?>
