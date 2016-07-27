<?php

namespace jasir;

use InvalidArgumentException;

class SimpleTemplate
{

	/**
	 * @param string $template
	 * @param array|callback $replace Either array with replaces or callback that takes string to be replaced
	 * @param string $openMark
	 * @param string $closeMark
	 * @return string
	 */
	public static function replaceVariables($template, $replace, $openMark = '{', $closeMark = '}')
	{
		if (!is_array($replace) && !is_callable($replace)) {
			throw new InvalidArgumentException('Parameter $replace must be either array or callable');
		}
		$openMark = preg_quote($openMark);
		$closeMark = preg_quote($closeMark);
		return preg_replace_callback(
			"~{$openMark}([a-z_-][-\.a-z0-9_]*|{$closeMark}){$closeMark}~i",
			function ($match) use ($replace) {
				if (is_array($replace)) {
					return isset($replace[$match[1]]) ? $replace[$match[1]] : $match[0];
				} elseif (is_callable($replace)) {
					return $replace($match[0]);
				}
			},
			$template
		);
	}
}