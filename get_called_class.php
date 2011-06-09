<?php
if (! function_exists('get_called_class')) {
	function get_called_class() {
		$traces = debug_backtrace();
		$caller = $traces[1];
		if (! isset($caller['file'])) {
			if (isset($traces[2]['args'][0][0])) return $traces[2]['args'][0][0];
			trigger_error('get_called_class() can not find a class', E_USER_WARNING);
		} else {
			$file = file($caller['file']);
			$pattern = sprintf('/([a-zA-Z\_0-9]+)::%s\s*?\(/', $caller['function']);
			for ($line = $caller['line']; $line > 0; --$line) {
				if (preg_match($pattern, $file[$line], $matches)) {
					if ($matches[1] === 'self') $pattern = '/class\s+([a-zA-Z\_0-9]+)\s+/';
					else return $matches[1];
				}
			}
			trigger_error('get_called_class() can not find a class', E_USER_WARNING);
		}
	}
}
