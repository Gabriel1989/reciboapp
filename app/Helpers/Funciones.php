<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Funciones
{
    public static function getRealQuery($query, $dumpIt = false)
	{
		$params = array_map(function ($item) {
			return "'{$item}'";
		}, $query->getBindings());
		$result = self::str_replace_array('\?', $params, $query->toSql());
		if ($dumpIt) {
			dd($result);
		}
		return $result;
	}

    public static function str_replace_array($search, array $replace, $subject)
	{
		foreach ($replace as $value)
		{
			$subject = preg_replace('/'.$search.'/', $value, $subject, 1);
		}

		return $subject;
	}

}