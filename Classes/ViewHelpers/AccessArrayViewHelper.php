<?php
namespace Dmind\Cookieman\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class AccessArrayViewHelper extends AbstractViewHelper
{
	/**
	 * @param array $array
	 * @param mixed $keys
	 * @return mixed
	 */
	public function render($array, $keys)
	{
		if(!is_array($array))
		{
			return;
		}
		if(is_string($keys))
		{
			return $array[$keys];
		}
		if(is_array($keys))
		{
			$iKey = array_shift($keys);
			if(count($keys) > 0)
			{
				return $this->render($array[$iKey], $keys);
			}
			return $array[$iKey];
		}

	}


}
