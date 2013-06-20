<?php namespace Vinelab\Assistant;

Class Formatter {

	/**
	 * Turn a word into snake_case
	 * @param  string $word the word to snakify
	 * @return string
	 */
	public function snakify($word)
	{
		return strtolower(str_replace(' ', '_', $word));
	}

	/**
	 * Turn a word into CamelCase
	 * @param  string $word The word to camelify
	 * @return string
	 */
	public function camelify($word)
	{
		preg_match('/\s/', $word, $matches, PREG_OFFSET_CAPTURE);

		if (count($matches) > 0)
		{
			$ending = str_replace(' ','',ucwords(str_replace('_', ' ', substr($word, $matches[0][1]))));
			$beginning = strtolower(substr($word, 0, $matches[0][1]));
			return $beginning.$ending;

		} else {
			return $word;
		}
	}

	/**
	 * Removes spaces, dashes, dots, commas and underscores from the given string
	 * @param  string $string
	 * @return string
	 */
	public function neutralize($string)
	{
		return preg_replace('/\s|-|\.|,|_/i', '', strtolower($string));
	}

	/**
	 * Turns all spaces into dashes in a string
	 * @param  string $string
	 * @return string
	 */
	public function dashit($string)
	{
		return strtolower(str_replace(' ', '-', $string));
	}

	/**
	 * Formats a date into a given pattern - default is d/m/y
	 * Mostly used when printing
	 * @param  string $date
	 * @param  [type] $pattern     your choice of these http://php.net/manual/en/function.date.php
	 * @return string
	 */
	public function date($date, $pattern = null)
	{
		$default_pattern = 'd/m/y';

		if (empty($date)) return date($pattern ?: $default_pattern);
		return !is_null(strtotime($date)) ? date($pattern ?: $default_pattern, strtotime($date)) : null;
	}
}