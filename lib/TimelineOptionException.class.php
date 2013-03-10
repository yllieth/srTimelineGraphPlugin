<?php

class TimelineOptionException extends TimelineGraphException {
	
	public function __construct(Array $optionInfo, $code = null, $previous = null) 
	{
		$optionName = $optionInfo[0];
		$expected   = $optionInfo[1];
		$given      = $optionInfo[2];
		
		if     (is_null($given))	$givenClass = "null";
		elseif (is_numeric($given))	$givenClass = "int";
		elseif (is_string($given))	$givenClass = "string";
		elseif (is_bool($given))	$givenClass = "boolean";
		elseif (is_array($given))	$givenClass = "array";
		elseif (is_object($given))	$givenClass = get_class($given);
		
		$message = sprintf("L'option [%s] doit etre %s et non [(%s) %s].", $optionName, $expected, $givenClass, $given);
		
		parent::__construct($message, $code, $previous);
	}
	
}

?>
