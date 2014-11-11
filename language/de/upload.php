<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @translate in German by Michel_61 (http://www.phpbb.de)
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Erweiterungen hochladen und aktivieren',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Erweiterungen hochladen',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Hier können, anstatt über einen FTP Zugang, Zip-Archive vom PC hochgeladen, als Erweiterung installiert und/oder gelöscht und Updates installiert werden.',
	'UPLOAD'							=> 'hochladen',
	'BROWSE'							=> 'Zeige Inhalt',
	'EXTENSION_UPLOAD'					=> 'Erweiterung hochladen',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Das Zip-Archiv einer Erweiterung enthält alle notwendigen Dateien um nach dem Hochladen des Archives eine Installation durchführen zu können. Dazu wird das Zip-Archiv nach dem Hochladen vom eigenen PC auf dem Server in das durch die Erweiterung vorgegebene Verzeichnis entpackt.<br />Hierunter im leeren Feld den Pfad zum Zip-Archiv eingeben.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Es gab einen Fehler bei der Initialisierung der Erweiterung Upload-Prozess.',
	'EXT_NOT_WRITABLE'					=> 'Das ext/ Verzeichnis ist nicht beschreibbar. Für das Hochladen von Dateien ist es erforderlich die Verzeichnissrechte entsprechend einzustellen und anzupassen. Danach den Vorgang wiederholen.',
	'EXT_UPLOAD_ERROR'					=> 'Die Erweiterung wurde nicht hochgeladen. Bitte das Zip-Archiv auf Echtheit und Vollständigkeit überprüfen und erneut versuchen.',
	'NO_UPLOAD_FILE'					=> 'Keine Datei angegeben, oder es gab einen Fehler beim Hochladen.',
	'NOT_AN_EXTENSION'					=> 'Das hochgeladene Zip-Archiv ist keine phpBB-Erweiterung. Die Dateien wurde nicht auf dem Server gespeichert.',

	'EXTENSION_UPLOADED'				=> 'Erweiterung “%s” wurde erfolgreich hochgeladen.',
	'EXTENSIONS_AVAILABLE'				=> 'verfügbaren Erweiterungen',
	'EXTENSION_INVALID_LIST'			=> 'Erweiterungsliste',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Aktiviere die hochgeladene Erweiterung.',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Erweiterung entpacken',
	'ACP_UPLOAD_EXT_CONT'				=> 'Inhalt des Zip-Archivs: %s',

	'EXTENSION_DELETE'					=> 'Erweiterung Löschen',
	'EXTENSION_DELETE_CONFIRM'			=> 'Bist du sicher das du die Erweiterung “%s” löschen möchtest?',
	'EXT_DELETE_SUCCESS'				=> 'Erweiterung erfolgreich gelöscht.',

	'EXTENSION_ZIP_DELETE'				=> 'Zip-Archiv Löschen',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Bist du sicher das du das Zip-Archiv “%s” löschen möchtest?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Zip-Archiv erfolgreich gelöscht.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Kein Anbieter oder Zielordner in der hochgeladenen Zip-Datei. Die Datei wurde nicht auf dem Server gespeichert.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'Die Datei composer.json wurde nicht in der hochgeladenen Zip-Datei gefunden. Die Datei wurde nicht auf dem Server gespeichert.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Die Datei wurde nicht auf dem Server gespeichert.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Ein Fehler ist bei der Aktualisierung einer bereits installierten Erweiterung aufgetreten. Bitte wiederhole die Aktualisierung.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Entwickler',

	'SHOW_FILETREE'						=> '<< Verzeichnis anzeigen >>',
	'HIDE_FILETREE'						=> '>> Verzeichnis ausblenden <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Hochgeladenes Zip-Archiv speichern',
	'ZIP_UPLOADED'						=> 'Zip-Archiv der Erweiterung hochgeladen',
	'EXT_ENABLE'						=> 'Aktivieren',
	'EXT_UPLOADED'						=> 'Hochgeladen',
	'EXT_UPDATED'						=> 'aktualisiert',
	'EXT_UPDATED_LATEST_VERSION'		=> 'auf die neueste Version aktualisiert',
	'EXT_UPLOAD_BACK'					=> '« Zurück zum hochladen von Erweiterungen',

	'ACP_UPLOAD_EXT_DIR'				=> 'Speicherpfad der Zip-Archive der Erweiterungen',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Pfad unter dem phpBB root-Ordner, z.B. <samp>ext</samp>.<br />Du kannst diesen Pfad ändern um die Zip-Archive in einem besonderen Ordner zu speichern (z.B. in <em>downloads</em>, wenn du deinen Mitgliedern die Möglichkeit geben willst, die Archive runterzuladen, oder in einen Pfad außerhalb des http-roots om einen Zugriff von außen zu unterbinden (oder in einem Ordner mit einer entsprechenden .htaccess-Datei)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'Die installierte Erweiterung wurde aktualisiert.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Du hast ein Zip-Archiv zu einer bereits installierten Erweiterung hochgeladen. Diese Erweiterung wurde <strong>automatisch deaktiviert</strong> um eine sichere Aktualiserung zu gewährleisten. Bitte <strong>kontrolliere</strong>, daß die hochgeladenen Daten korrekt sind und <strong>aktiviere</strong> danach die Erweiterung.',
));
