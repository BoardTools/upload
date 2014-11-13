<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @translated into Swedish by Holger (http://www.maskinisten.net)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_UPLOAD_EXT_TITLE'				=> 'Ladda upp och aktivera plugins',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Ladda upp plugins',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Här kan du ladda upp plugin-zip-filer direkt från din PC istället för via FTP och installera, radera och uppdatera plugins.',
	'UPLOAD'							=> 'ladda upp',
	'BROWSE'							=> 'Visa innehåll',
	'EXTENSION_UPLOAD'					=> 'Ladda upp plugin',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'En plugin-zip-fil innehåller alla filer och informationer som krävs för installation av ett plugin efter uppladdningen. Zip-filen packas efter uppladdningen upp i motsvarande katalog på servern.<br />Ange sökvägen till zip-filen i fältet nedan.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Ett fel uppstod under initialiseringen av uppladdningsproceduren för plugins.',
	'EXT_NOT_WRITABLE'					=> 'Katalogen /ext/ är ej skrivbar. Filerna kan endast laddas upp och sparas i katalogen om behörigheterna är korrekta. Ställ in rätt behörighet och upprepa uppladdningen.',
	'EXT_UPLOAD_ERROR'					=> 'Detta plugin har ej laddats upp. Kontrollera att zip-filen är korrekt och fullständig och upprepa uppladdningen.',
	'NO_UPLOAD_FILE'					=> 'Ingen fil har angivits eller ett fel uppstod under uppladdningen.',
	'NOT_AN_EXTENSION'					=> 'Den uppladdade zip-filen innehåller inget phpBB-plugin. Filerna har ej sparats på severn.',

	'EXTENSION_UPLOADED'				=> 'Plugin “%s” har laddats upp.',
	'EXTENSIONS_AVAILABLE'				=> 'tillgängliga plugin',
	'EXTENSION_INVALID_LIST'			=> 'Lista över plugin',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Aktivera uppladdat plugin.',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Packa upp plugin',
	'ACP_UPLOAD_EXT_CONT'				=> 'Zip-filens innehåll: %s',

	'EXTENSION_DELETE'					=> 'Radera plugin',
	'EXTENSION_DELETE_CONFIRM'			=> 'Är du säker på att du vill radera plugin “%s”?',
	'EXT_DELETE_SUCCESS'				=> 'Detta plugin har raderats.',
	'EXT_DELETE_ERROR'					=> 'Ingen fil har angivits eller ett fel uppstod under uppladdningen.',

	'EXTENSION_ZIP_DELETE'				=> 'Radera zip-filen',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Är du säker på att du vill radera zip-filen “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Zip-filen har raderats.',
	'EXT_ZIP_DELETE_ERROR'				=> 'Ingen fil har angivits eller ett fel uppstod under uppladdningen.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Ingen vendor eller sökväg har angivits i den uppladdade zip-filen. Filen sparade ej på servern.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'Filen composer.json kunde ej hittas i den uppladdade zip-filen. Filen sparade ej på servern.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Filen sparade ej på servern.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Ett fel uppstod under uppdateringen av ett installerat plugin. Upprepa uppdateringen.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Programmerare',

	'SHOW_FILETREE'						=> '<< Visa katalog >>',
	'HIDE_FILETREE'						=> '>> Dölj katalog <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Spara uppladdad zip-fil',
	'ZIP_UPLOADED'						=> 'Plugin-zip-fil har laddats upp',
	'EXT_ENABLE'						=> 'Aktivera',
	'EXT_UPLOADED'						=> 'Uppladdat',
	'EXT_UPDATED'						=> 'Uppdaterat',
	'EXT_UPDATED_LATEST_VERSION'		=> 'Uppdaterat till senaste versionen',
	'EXT_UPLOAD_BACK'					=> '« Tillbaka till uppladdning av plugin',

	'ACP_UPLOAD_EXT_DIR'				=> 'Sökväg för plugin-zip-filer',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Sökväg under din phpBB root-katalog, t.ex. <samp>ext</samp>.<br />du kan ändra sökvägen så att zip-filerna sparas i en annan speciell katalog (om du t.ex. vill låta andra ladda ner dessa filer så kan du ändra det till <em>downloads</em>, och om du vill förbjuda nerladdning så ändrar du sökvägen till utanför din webbsidas http-root (eller en katalog med motsvarande .htaccess-fil)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'Installerat plugin har uppdaterats.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Du har laddat upp en zip-fil för ett plugin som redan är istallerat. Detta plugin <strong>deaktiverades automatiskt</strong> för att säkerställa uppdateringsproceduren. Nu bör du <strong>kontrollera</strong> att de uppladdade filerna är korrekta och <strong>aktivera</strong> detta plugin om du fortfarande vill använda det i forumet.',

	'VALID_PHPBB_EXTENSIONS'			=> 'phpbb.com CDB',
));
