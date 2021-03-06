<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Quickicon.Extensionupdate
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla! udpate notification plugin
 *
 * @package     Joomla.Plugin
 * @subpackage  Quickicon.Extensionupdate
 * @since       2.5
 */
class PlgQuickiconExtensionupdate extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 *
	 * @since       2.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Returns an icon definition for an icon which looks for extensions updates
	 * via AJAX and displays a notification when such updates are found.
	 *
	 * @param  $context  The calling context
	 *
	 * @return array A list of icon definition associative arrays, consisting of the
	 *				 keys link, image, text and access.
	 *
	 * @since       2.5
	 */
	public function onGetIcons($context)
	{
		if ($context != $this->params->get('context', 'mod_quickicon') || !JFactory::getUser()->authorise('core.manage', 'com_installer'))
		{
			return;
		}

		JHtml::_('jquery.framework');

		$ajax_url = JURI::base().'index.php?option=com_installer&view=update&task=update.ajax';
		$script = "var plg_quickicon_extensionupdate_ajax_url = '$ajax_url';\n";
		$script .= 'var plg_quickicon_extensionupdate_text = {"UPTODATE" : "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_UPTODATE', true).'", "UPDATEFOUND": "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_UPDATEFOUND', true).'", "ERROR": "'.
			JText::_('PLG_QUICKICON_EXTENSIONUPDATE_ERROR', true)."\"};\n";
		$document = JFactory::getDocument();
		$document->addScriptDeclaration($script);
		JHtml::_('script', 'plg_quickicon_extensionupdate/extensionupdatecheck.js', false, true);

		return array(array(
			'link' => 'index.php?option=com_installer&view=update',
			'image' => 'asterisk',
			'icon' => 'header/icon-48-extension.png',
			'text' => JText::_('PLG_QUICKICON_EXTENSIONUPDATE_CHECKING'),
			'id' => 'plg_quickicon_extensionupdate'
		));
	}
}
