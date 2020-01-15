<?php
namespace Dmind\Cookieman\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class JsonViewHelper extends AbstractViewHelper
{
	/**
	 * @param mixed $value
	 * @param bool $forceObject
	 * @return string
	 */
	public function render($value, $forceObject = FALSE)
	{
		$options = JSON_HEX_TAG;

		if ($forceObject !== false) {
			$options |= JSON_FORCE_OBJECT;
		}
		return json_encode($value, $options);
	}
}
