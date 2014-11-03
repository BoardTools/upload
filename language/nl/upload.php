<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Upload Extensions',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Upload extensions',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Upload Extensions maakt het mogelijk om zip bestanden van extensies te üploaden of extensies te verwijderen.<br />Met deze extensie kun je extensies installeren/updaten/verwijderen zonder FTP te gebruiken. Als de geüploade extensie al bestaat, wordt de huidige extensie geüpdatet.',
	'UPLOAD'							=> 'Uploaden',
	'BROWSE'							=> 'Bladeren...',
	'EXTENSION_UPLOAD'					=> 'Upload extensie',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Hier kun je een zip bestand uploaden dat de vereiste bestanden bevat om een extensie te instaleren vanaf een lokale computer of een andere server. “Upload Extensions” zal het zip bestand uitpakken en klaarmaken voor installatie.<br />Kies een bestand of typ een link hier beneden.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Er is een fout opgetreden bij het voorbereiden op de installatie.',
	'EXT_NOT_WRITABLE'					=> 'De ext/ map is niet schrijfbaar. Dit is vereist om “Upload extension” goed te laten functioneren. Verander de permissies of probeer het opnieuw.',
	'EXT_UPLOAD_ERROR'					=> 'De extensie is niet geüpload. Controleer of het een zip bestand is en probeer het opnieuw.',
	'NO_UPLOAD_FILE'					=> 'Geen bestand gekozen of er was een probleem met het uploaden',
	'NOT_AN_EXTENSION'					=> 'Het zip bestand bevat geen phpBB extensie. Het bestand is niet opgeslagen op de server.',

	'EXTENSION_UPLOADED'				=> 'Extensie “%s” succesvol geüpload.',
	'EXTENSIONS_AVAILABLE'				=> 'Beschikbare extensies',
	'EXTENSION_INVALID_LIST'			=> 'Lijst van extensies',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Schakel de geüploade extensie in',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Extensie uitpakken',
	'ACP_UPLOAD_EXT_CONT'				=> 'Inhoud van bestand: %s',

	'EXTENSION_DELETE'					=> 'Verwijder extensie',
	'EXTENSION_DELETE_CONFIRM'			=> 'Weet je zeker dat je de extensie “%s” wil verwijderen?',
	'EXT_DELETE_SUCCESS'				=> 'Extensie succesvol verwijderd.',

	'EXTENSION_ZIP_DELETE'				=> 'Verwijder zip bestand',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Weet je zeker dat je het zip bestand “%s” wil verwijderen?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Het zip bestand van de extensie is succesvol verwijderd.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Geen vendor of bestandslocatie gevonden in het bestand. Het bestand is niet opgeslagen op de server.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json is niet gevonden in het zip bestand. Het bestand is niet opgeslagen op de server.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Het bestand is niet opgeslagen op de server.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Er is een fout opgetreden tijdens het updaten. Probeer opnieuw te updaten.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Ontwikkelaars',

	'SHOW_FILETREE'						=> '<< Toon bestandsvertakkingen >>',
	'HIDE_FILETREE'						=> '>> Verberg bestandsvertakkingen <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Sla zip bestand op',
	'ZIP_UPLOADED'						=> 'Zip bestanden van extensies opgeslagen',
	'EXT_ENABLE'						=> 'Inschakelen',
	'EXT_UPLOADED'						=> 'geüpload',
	'EXT_UPDATED'						=> 'geüpdatet',
	'EXT_UPDATED_LATEST_VERSION'		=> 'update naar de laatste versie',
	'EXT_UPLOAD_BACK'					=> '« Terug naar Upload Extensions',

	'ACP_UPLOAD_EXT_DIR'				=> 'Pad naar zip bestand van extensie',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Pad onder je phpBB installatie, b.v. <samp>ext</samp>.<br />Je kunt dit veranderen om zip bestanden ergens anders op te slaan (bijvoorbeeld, als je gebruikers deze bestanden wil laten downloaden, kun je het veranderen naar <em>downloads</em>, als je downloaden wil verbieden, kun je het pad veranderen naar een dat een hoger http level heeft (of je kunt een map maken met een geschikt .htaccess bestand)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'De geïnstalleerde extensie is geüpdatet.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Je hebt een zip bestand geüpload voor een extensie die al geïnstalleerd is. Deze extensie <strong>is automatisch uitgeschakeld</strong> om het update proces veiliger te maken. <strong>Controleer</strong> nu of de geüploade bestanden juist zijn en <strong>schakel de extensie in</strong> als het gebruikt wordt op het forum.',
));
