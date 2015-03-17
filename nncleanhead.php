<?php
/**
 * @version 1.0.0
 * @package NNCleanhead
 * @copyright Copyright (c) 2009 - 2015 Niels Nübel
 * @license GNU General Public License version 2 or later;
 * @link http://www.niels-nuebel.de
 */

defined('_JEXEC') or die;

/**
 * Plugin class to modify the JDocumentHTML object
 *
 * @since  3.1
 */
class plgSystemNNCleanhead extends JPlugin
{
	public function onBeforeCompileHead()
	{
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		if($app->isSite() == false)
		{
			return false;
		}

		// disable js
		if ( $this->params->get('disablejs',false) )
		{
			$fnjs = $this->params->get('fnjs','');
			if (trim($fnjs) != '')
			{
				$filesjs = explode(',', $fnjs);
				if ($this->params->get('widgetkitjquery',0))        $filesjs[] = 'media/widgetkit/js/jquery.js';
				if ($this->params->get('jui-jquery',0))             $filesjs[] = 'media/jui/js/jquery.min.js';
				if ($this->params->get('jui-jquery-migrate',0))     $filesjs[] = 'media/jui/js/jquery-migrate.min.js';
				if ($this->params->get('jui-jquery-noconflict',0))  $filesjs[] = 'media/jui/js/jquery-noconflict.js';
				if ($this->params->get('jui-bootstrap',0)) {
					$filesjs[] = 'media/jui/js/bootstrap.min.js';
					$filesjs[] = 'media/jui/js/bootstrap.js';
				}
				if ($this->params->get('caption',0))               $filesjs[] = 'media/system/js/caption.js';
				$scripts = array();

				foreach($document->_scripts as $name => $details)
				{
					$add = true;
					foreach ($filesjs as $dis)
					{
						if (strpos($name,$dis) !== false)
						{
							$add = false;
							break;
						}
					}
					if ($add) $scripts[$name] = $details;
				}

				$document->_scripts = $scripts;
			}
		}

		//load first
		if ( $this->params->get('loadfirst',false) )
		{
			$firstscript = array();
			$scripts = array();
			foreach($document->_scripts as $name => $details)
			{
				if (strpos($name, $this->params->get('loadfirst')) !== false)
				{
					$firstscript[$name] = $details;
				}
				else {
					$scripts[$name] = $details;
				}
			}
			$newscriptorder = array_merge($firstscript,$scripts);

			$document->_scripts = $newscriptorder;
		}

		// disable css
		if ( $this->params->get('disablecss',false) )
		{
			$fncss = $this->params->get('fncss','');
			if (trim($fncss) != '')
			{
				$filescss = explode(',', $fncss);
				$styleSheets = array();

				foreach($document->_styleSheets as $name => $details)
				{
					$add = true;
					foreach ($filescss as $dis)
					{
						if (strpos($name,$dis) !== false)
						{
							$add = false;
							break;
						}
					}

					if ($add) $styleSheets[$name] = $details;
				}

				$document->_styleSheets = $styleSheets;
			}
		}
	}
}
