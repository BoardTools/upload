<?php
/**
* upload.php [Estonian]
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @copyright (c) 2014 Upload Extensions Estonian language pack version 0.1 by http://www.phpbbeesti.com/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Laadi laiendus üles',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Laadi laiendus üles',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Laadi laiendus üles lubab sul üles laadida laienduste zip faile või kustutada nende kauste serverist.<br />Antud laiendusega sa saad paigaldada/uuendada/kustutada laiendusi ilma, et peaksid kasutama FTP\'d. Kui aga üles laaditud laiendus juba eksisteerib, siis seda uuendatakse üles laetud failidega.',
	'UPLOAD'							=> 'Laadi üles',
	'BROWSE'							=> 'Sirvi...',
	'EXTENSION_UPLOAD'					=> 'Laadi laiendus üles',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Siin saad üles laadida kokku pakitud .zip faile. “Laadi laiendus üles” pakib selle ise lahti, ning seadistab selle sulle paigaldamiseks valmis.<br />Vali fail arvutist või kirjuta veebilehe aadress all olevale väljale.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Tekkis viga, kui alustati laienduse üles laadimise protsessi.',
	'EXT_NOT_WRITABLE'					=> 'ext/ kaust ei ole kirjutatav. See on nõutud, et “Laadi laiendus üles” töötaks korralikult. Palun kohanda antud seadistust, ning proovi uuesti.',
	'EXT_UPLOAD_ERROR'					=> 'Laiendust ei laaditud üles. Palun veendu, et laadisid üles õige laienduse .zip faili ja proovi uuesti.',
	'NO_UPLOAD_FILE'					=> 'Ühtegi faili pole määratud või tekkis viga üles laadimise protsessi jooksul.',
	'NOT_AN_EXTENSION'					=> 'Üles laaditud zip fail ei ole phpBB laiendus. Faili ei salvestatud serverisse.',

	'EXTENSION_UPLOADED'				=> 'Laiendus “%s” on edukalt üles laaditud.',
	'EXTENSIONS_AVAILABLE'				=> 'Saadaval laiendused',
	'EXTENSION_INVALID_LIST'			=> 'Laienduste nimekiri',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Luba üles laaditud laiendused',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Paki laiendus lahti',
	'ACP_UPLOAD_EXT_CONT'				=> 'Paki sisu: %s',

	'EXTENSION_DELETE'					=> 'Kustuta laiendus',
	'EXTENSION_DELETE_CONFIRM'			=> 'Oled sa kindel, et soovid kustutada “%s” laienduse?',
	'EXT_DELETE_SUCCESS'				=> 'Laiendus on edukalt kustutatud.',
	'EXT_DELETE_ERROR'					=> 'Ühtegi faili pole määratud või tekkis viga üles laadimise protsessi jooksul.',

	'EXTENSION_ZIP_DELETE'				=> 'Kustuta zip fail',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Oled sa kindel, et soovid kustutada zip faili - “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Laienduse zip fail on edukalt kustutatud.',
	'EXT_ZIP_DELETE_ERROR'				=> 'Ühtegi faili pole määratud või tekkis viga üles laadimise protsessi jooksul.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Vendor\'it või kausta sihtkohta üles laaditud zip failil pole. Faili ei salvestatud serverisse.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json ei leitud üles laaditud zip failist. Faili ei salvestatud serverisse.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Faili ei salvestatud serverisse.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Olemasoleva laienduse uuendamisel tekkis viga. Proovi palun uuesti uuendada.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Arendajad',

	'SHOW_FILETREE'						=> '<< Näita faili puud >>',
	'HIDE_FILETREE'						=> '>> Peida faili puu <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Salvesta üles laaditud zip fail',
	'ZIP_UPLOADED'						=> 'zip arhiiv on üles laaditud',
	'EXT_ENABLE'						=> 'Luba',
	'EXT_UPLOADED'						=> 'üles laaditud',
	'EXT_UPDATED'						=> 'uuendatud',
	'EXT_UPDATED_LATEST_VERSION'		=> 'uuendatud uusimale versioonile',
	'EXT_UPLOAD_BACK'					=> '« Tagasi “Laadi laiendus üles” lehele',

	'ACP_UPLOAD_EXT_DIR'				=> 'Laienduste zip failide teekond',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Teekond sinu phpBB root kausta, näiteks <samp>ext</samp>.<br />Sa saad muuta seda teekonda, kuhu salvestakse zip failid (näiteks, kui soovid lasta liikmetel ja ka külalistel allalaadida neid faile, siis muuda see kaustaks <em>downloads</em>. Kui sa aga soovid keelata allalaadimise, siis saad muuta teekonna üks level üles poole minnes oma serveri kaustas, mis ei oleks http root. (Samuti sa võid luua kausta, kus on asjakohane .htaccess fail sees, mis keelaks leheküljele sisenemise ja allalaadimise)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'Paigaldatud laiendus on uuendatud.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Sa oled üles laadinud juba olemas oleva laienduse zip faili. Antud laiendus <strong>keelati automaatselt</strong>, et teha uuendamise protsess ohutumaks. Nüüd palun <strong>kontrolli</strong> kas üles laaditud failid oli õiged, ning <strong>luba</strong> laiendus, kui on see kasutusel foorumis.',

	'VALID_PHPBB_EXTENSIONS'			=> 'phpbb.com CDB',
));
