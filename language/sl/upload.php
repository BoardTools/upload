<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2019 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Slovenian Translation - Marko K.(max, max-ima,...)
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Nalaganje razširitev',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Nalaganje razširitev',
	'ACP_UPLOAD_EXT_DESCRIPTION'		=> 'Namestite/posodobite/izbrišite razširitve, upravljajte njihove datoteke ZIP in še več brez uporabe FTP.',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Nalaganje razširitev vam omogoča, da naložite zip datoteke razširitev ali izbrišete mape razširitev s strežnika.<br />S to razširitvijo lahko namestite/posodabljate/brišete razširitve brez uporabe FTP-ja. Če naložena razširitev že obstaja, bo posodobljena z naloženimi datotekami.',
	'ACP_UPLOAD_EXT_HELP'				=> 'Nalaganje razširitev: Vodnik za uporabo',
	'UPLOAD'							=> 'Naloži',
	'BROWSE'							=> 'Prebrskaj ...',
	'EXTENSION_UPLOAD'					=> 'Naložite razširitev',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Tukaj lahko naložite stisnjen razširitveni paket, ki vsebuje potrebne datoteke za izvedbo namestitve iz vašega lokalnega računalnika ali oddaljenega strežnika. “Naloži razširitve” bo nato poskušal razpakirati datoteko in jo pripraviti za namestitev.<br />Izberite datoteko ali vnesite povezavo v spodnja polja.',
	'EXT_UPLOAD_ERROR'					=> 'Razširitev ni bila naložena.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Pri inicializaciji postopka nalaganja razširitve je prišlo do napake.',
	'EXT_NOT_WRITABLE'					=> array(
		'error'		=> 'V imenik ext/ ni mogoče zapisovati. To je potrebno za pravilno delovanje “Nalaganje razširitev”.',
		'solution'	=> 'Prosimo, prilagodite svoja dovoljenja ali nastavitve in poskusite znova.',
	),
	'EXT_TMP_NOT_WRITABLE'				=> array(
		'error'		=> 'V imenik ext/boardtools/upload/tmp/ ni mogoče zapisovati. To je potrebno za pravilno delovanje “Nalaganje razširitev”.',
		'solution'	=> 'Prosimo, prilagodite svoja dovoljenja ali nastavitve in poskusite znova.',
	),
	'EXT_ALLOW_URL_FOPEN_DISABLED'		=> array(
			'error'		=> 'Za nalaganje informacij iz oddaljenega vira mora biti omogočena nastavitev allow_url_fopen.',
			'solution'	=> 'Potrdite, da je nastavitev allow_url_fopen omogočena v vašem php.ini in poskusite znova.',
	),
	'EXT_OPENSSL_DISABLED'				=> array(
			'error'		=> 'Razširitev openssl mora biti omogočena za nalaganje informacij iz vira https.',
			'solution'	=> 'Potrdite, da je razširitev openssl omogočena v vašem php.ini in poskusite znova.',
	),
	'NO_UPLOAD_FILE'					=> array(
		'error'		=> 'Nobena datoteka ni določena ali pa je med postopkom nalaganja prišlo do napake.',
		'solution'	=> 'Potrdite, da ste naložili pravo razširitev zip datoteko in poskusite znova.',
	),
	'NOT_AN_EXTENSION'					=> 'Naložena datoteka zip ni razširitev phpBB. Datoteka ni bila shranjena na strežniku.',
	'EXT_ACTION_ERROR'					=> 'Zahtevanega dejanja ni mogoče izvesti za izbrano razširitev phpBB.<br />Opomba: “Nalaganje razširitev” je mogoče upravljati samo prek standardnega upravitelja razširitev.',

	'SOURCE'							=> 'Vir',
	'EXTENSION_UPDATE_NO_LINK'			=> 'Povezava za prenos ni navedena.',
	'EXTENSION_TO_BE_ENABLED'			=> 'Razširitve za nalaganje bodo onemogočene med postopkom posodobitve in ponovno omogočene po posodobitvi.',
	'EXTENSION_UPLOAD_UPDATE'			=> 'Posodobite razširitev',
	'EXTENSION_UPLOAD_UPDATE_EXPLAIN'	=> '“Nalaganje razširitev” bodo opravile nalaganje s spodnje povezave.',

	'EXTENSION_UPLOADED'				=> 'Razširitev “%s” je bila uspešno naložena.',
	'EXTENSIONS_AVAILABLE'				=> 'Nenameščene razširitve',
	'EXTENSIONS_UPLOADED'				=> 'Naložene razširitve',
	'EXTENSIONS_UNAVAILABLE'			=> 'Pokvarjene razširitve',
	'EXTENSIONS_UNAVAILABLE_EXPLAIN'	=> 'Spodaj navedene razširitve so naložene na vašo ploščo, vendar so zaradi nekaterih razlogov pokvarjene in zato niso na voljo in jih ni mogoče omogočiti na vaši plošči. Preverite prave datoteke in uporabite orodje Čistilec za razširitve, če želite izbrisati datoteke pokvarjenih razširitev s strežnika.',
	'EXTENSION_BROKEN'					=> 'Pokvarjene razširitve',
	'EXTENSION_BROKEN_ENABLED'			=> 'Ta pokvarjena razširitev je omogočena!',
	'EXTENSION_BROKEN_DISABLED'			=> 'Ta pokvarjena razširitev je onemogočena!',
	'EXTENSION_BROKEN_TITLE'			=> 'Ta razširitev je pokvarjena!',
	'EXTENSION_BROKEN_DETAILS'			=> 'Kliknite tukaj za ogled podrobnosti.',
	'EXTENSION_BROKEN_EXPLAIN'			=> '<strong>Nekateri podatki te razširitve so še vedno shranjeni v strežniku.</strong> Preverite, zakaj je ta razširitev pokvarjena. Morda boste morali za pomoč prositi razvijalce razširitev in uporabiti FTP za spreminjanje nekaterih datotek (ali pa lahko naložite različico s popravki). Nato boste lahko znova upravljali razširitev.<br /><h3>Kaj lahko storite:</h3><br /><strong>Posodobite pokvarjeno razširitev.</strong><br /><ul> <li>Prepričajte se, da je razširitev onemogočena (po potrebi kliknite na preklop).</li><li>Ugotovite, ali je na voljo nova različica razširitve. Poskusite jo naložiti.</li><li>Če težava ni odpravljena, lahko prosite za pomoč razvijalce razširitve.</ul><strong>ali</strong><br /><br /> <strong>Popolnoma odstranite pokvarjeno razširitev.</strong><br /><ul><li>Prepričajte se, da je razširitev onemogočena (po potrebi kliknite stikalo).</li><li>Prepričajte se, da je razširitev nameščena. podatki razširitve so izbrisani (po potrebi kliknite gumb za koš za smeti).</li><li>Odstranite datoteke razširitve z orodjem Čistilec za razširitve.</ul>',

	'EXTENSION_UPLOADED_ENABLE'			=> 'Omogočite naloženo razširitev',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Razpakirajte razširitev',
	'ACP_UPLOAD_EXT_CONT'				=> 'Vsebina paketa “%s”',

	'EXT_LIST_DOWNLOAD'					=> 'Prenesite celoten seznam',
	'EXT_LIST_DOWNLOAD_ENGLISH'			=> 'Uporabite angleška statusna imena',
	'EXT_LIST_DOWNLOAD_GROUP'			=> 'Skupina po',
	'EXT_LIST_DOWNLOAD_GROUP_STANDARD'	=> 'naloženo/pokvarjeno',
	'EXT_LIST_DOWNLOAD_GROUP_DISABLED'	=> 'omogočeno/onemogočeno/pokvarjeno',
	'EXT_LIST_DOWNLOAD_GROUP_PURGED'	=> 'omogočeno/onemogočeno/odstranjeno/pokvarjeno',
	'EXT_LIST_DOWNLOAD_SHOW'			=> 'Vključite imena',
	'EXT_LIST_DOWNLOAD_SHOW_FULL'		=> 'prikazna imena in čista imena',
	'EXT_LIST_DOWNLOAD_SHOW_CLEAN'		=> 'samo čista imena',
	'EXT_LIST_DOWNLOAD_SHOW_NAME'		=> 'samo prikazna imena',
	'EXT_LIST_DOWNLOAD_TITLE'			=> 'Celoten seznam naloženih razširitev',
	'EXT_LIST_DOWNLOAD_FOOTER'			=> 'Ustvarjeno z Nalaganje razširitev',

	'EXT_ROW_ENABLED'					=> 'omogočeno',
	'EXT_ROW_DISABLED'					=> 'onemogočeno',
	'EXT_ROW_UNINSTALLED'				=> 'odstranjen',
	'EXT_ROWS_ENABLED'					=> 'Omogočeno:',
	'EXT_ROWS_DISABLED'					=> 'Onemogočeno:',
	'EXT_ROWS_UNINSTALLED'				=> 'Odstranjen:',
	'EXT_ROWS_UPLOADED'					=> 'Naloženo:',
	'EXT_ROWS_BROKEN'					=> 'Pokvarjeno:',

	'EXTENSION_DELETE'					=> 'Izbriši razširitev',
	'EXTENSION_DELETE_CONFIRM'			=> 'Ali ste prepričani, da želite izbrisati razširitev “%s”?',
	'EXTENSIONS_DELETE_CONFIRM'			=> array(
		2	=> 'Ali ste prepričani, da želite izbrisati razširitev <strong>%1$s</strong>?',
	),
	'EXT_DELETE_SUCCESS'				=> 'Razširitev je bila uspešno izbrisana.',
	'EXTS_DELETE_SUCCESS'				=> 'Razširitve so bile uspešno izbrisane.',
	'EXT_DELETE_ERROR'					=> 'Nobena datoteka ni določena ali pa je med brisanjem prišlo do napake.',
	'EXT_DELETE_NO_FILE'				=> 'Za brisanje ni bila navedena nobena datoteka.',
	'EXT_CANNOT_BE_PURGED'				=> 'Podatkov omogočene razširitve ni mogoče izbrisati. Onemogočite razširitev, da boste lahko izbrisali njene podatke.',

	'EXTENSION_ZIP_DELETE'				=> 'Izbriši zip datoteko',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Ali ste prepričani, da želite izbrisati zip datoteko “%s”?',
	'EXTENSIONS_ZIP_DELETE_CONFIRM'		=> array(
		2	=> 'Ali ste prepričani, da želite izbrisati zip datoteke <strong>%1$s</strong>?',
	),
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Zip datoteka razširitve je bila uspešno izbrisana.',
	'EXT_ZIPS_DELETE_SUCCESS'			=> 'Zip datoteke razširitev so bile uspešno izbrisane.',
	'EXT_ZIP_DELETE_ERROR'				=> 'Nobena datoteka ni določena ali pa je med brisanjem prišlo do napake.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'V naloženi datoteki zip ni prodajalca ali ciljne mape.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json ni bilo mogoče najti v naloženi datoteki zip. Datoteka ni bila shranjena na strežniku.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Datoteka ni bila shranjena na strežniku.',
	'ACP_UPLOAD_EXT_ERROR_TRY_SELF'		=> '“Nalaganje razširitev” je mogoče posodobiti samo s posebnim programom za posodobitev ali prek FTP.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'An error occurred during the update of an installed extension. Try to update it again.',

	'DEVELOPER'							=> 'Razvijalec',
	'DEVELOPERS'						=> 'Razvijalci',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Shranite naloženo zip datoteko',
	'CHECKSUM'							=> 'Kontrolna vsota',
	'RESTORE'							=> 'Obnovi',
	'ZIP_UPLOADED'						=> 'Naloženi zip paketi razširitev',
	'EXT_ENABLE'						=> 'Omogoči',
	'EXT_ENABLE_DISABLE'				=> 'Omogoči/Onemogoči razširitev',
	'EXT_ENABLED'						=> 'Razširitev je bila uspešno omogočena.',
	'EXT_DISABLED'						=> 'Razširitev je bila uspešno onemogočena.',
	'EXT_PURGE'							=> 'Očistite podatke razširitve',
	'EXT_PURGED'						=> 'Podatki razširitve so bili uspešno izbrisani.',
	'EXT_UPLOADED'						=> 'Nalaganje je bilo uspešno.',
	'EXT_UPDATE_ENABLE'					=> 'Kliknite na stikalo, da omogočite razširitev.',
	'EXT_UPDATE_CHECK_FILETREE'			=> 'Preverite drevo datotek razširitve.',
	'EXT_UPDATE_ERROR'					=> 'Pri postopku posodobitve je prišlo do napake.',
	'EXT_UPDATE_TIMEOUT'				=> 'Postopek posodobitve je potekel.',
	'EXT_UPDATES_AVAILABLE'				=> 'Na voljo so posodobitve',
	'EXT_UPDATE_METHODS_TITLE'			=> 'Razpoložljivi načini posodabljanja',
	'EXT_UPLOAD_UPDATE_METHODS'			=> 'Razširitev lahko posodobite tako, da izvedete eno od možnih dejanj:<ul><li><strong>Način posodabljanja.</strong> Razširitve za nalaganje lahko posodobite s programom Nalaganje razširitev posodobitev. Preverite, ali je to orodje že na voljo. Če nimate tega orodja, boste morali uporabiti drugo metodo.</li><li><strong>FTP metoda.</strong> Razširitve za nalaganje je mogoče posodobiti na standarden način. Prenesite nove datoteke v svoj računalnik (kliknite spodnji gumb), onemogočite razširitev v standardnem upravitelju razširitev, kopirajte nove datoteke s pomočjo odjemalca FTP in omogočite razširitev v standardnem upravitelju razširitev.</li></ul>',
	'EXT_UPDATED'						=> 'Posodobitev je bila uspešna.',
	'EXT_UPDATED_LATEST_VERSION'		=> 'posodobljen na najnovejšo različico',
	'EXT_SAVED_OLD_ZIP'					=> '<strong>OPOMBA:</strong> prejšnja različica razširitve je bila shranjena v datoteki <strong>%s</strong> na vašem strežniku. Oglejte si modul “Upravljanje datotek ZIP”.',
	'EXT_RESTORE_LANGUAGE'				=> '<strong>V naloženi različici razširitve ni imenika enega jezika.</strong> Imenik %s lahko obnovite iz shranjenega zip arhiva prejšnje različice. Nato boste morda morali posodobiti datoteke tega imenika zaradi združljivosti z naloženo različico razširitve.',
	'EXT_RESTORE_LANGUAGES'				=> '<strong>Nekateri jezikovni imeniki so odsotni v naloženi različici razširitve.</strong> Imenika %1$s in %2$s lahko obnovite iz shranjenega zip arhiva prejšnje različice. Potem boste morda morali posodobiti datoteke teh imenikov zaradi združljivosti z naloženo različico razširitve.',
	'EXT_LANGUAGES_RESTORED'			=> 'Postopek obnovitve je bil uspešno zaključen.',
	'EXT_SHOW_DESCRIPTION'				=> 'Pokaži opis razširitve',
	'EXT_UPLOAD_BACK'					=> '« Nazaj na Nalaganje razširitev',
	'EXT_RELOAD_PAGE'					=> 'Ponovno naložite stran',
	'EXT_REFRESH_PAGE'					=> 'Osvežite stran',
	'EXT_REFRESH_NOTICE'				=> 'Navigacijski meni je lahko zastarel.',

	'ERROR_COPY_FILE'					=> 'Poskus kopiranja datoteke “%1$s” na lokacijo “%2$s” ni uspel.',
	'ERROR_CREATE_DIRECTORY'			=> 'Poskus ustvarjanja imenika “%s” ni uspel.',
	'ERROR_REMOVE_DIRECTORY'			=> 'Poskus odstranitve imenika “%s” ni uspel.',
	'ERROR_CHECKSUM_MISMATCH'			=> '%s-hash naložene datoteke se razlikuje od podane kontrolne vsote. Datoteka ni bila shranjena na strežniku.',
	'ERROR_ZIP_NO_COMPOSER'				=> 'composer.json ni bilo mogoče najti v zahtevanem paketu zip.',
	'ERROR_DIRECTORIES_NOT_RESTORED'	=> 'Obnovitvenega postopka ni bilo mogoče dokončati zaradi napak.',
	'ERROR_LANGUAGE_UNKNOWN_STRUCTURE'	=> 'Struktura naloženega jezikovnega paketa ni prepoznana. Datoteka ni bila shranjena na strežniku.',
	'ERROR_LANGUAGE_NO_EXTENSION'		=> 'Ime razširitve ni navedeno za jezikovni paket.',
	'ERROR_LANGUAGE_NOT_DEFINED'		=> 'Za pravilno nalaganje jezikovnega paketa je treba določiti ISO kodo jezika. Izpolnite zahtevano polje obrazca in poskusite znova.',

	'ACP_UPLOAD_EXT_DIR'				=> 'Pot za shranjevanje paketov zip razširitev',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Pot pod vašim korenskim imenikom phpBB, npr. <samp>ext</samp>.<br />To pot lahko spremenite tako, da shranite pakete zip v posebno mapo (če želite na primer uporabnikom omogočiti prenos teh datotek, jo lahko spremenite v <em>prenosi</em>, in če želite te prenose prepovedati, lahko ga spremenite v pot, ki je za eno raven višja od http korena vašega spletnega mesta (ali pa ustvarite mapo z ustrezno datoteko .htaccess)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'Nameščena razširitev je bila posodobljena.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Naložili ste datoteko zip za že nameščeno razširitev. Ta razširitev <strong>je bila samodejno onemogočena</strong>, da je bil postopek posodabljanja varnejši. Zdaj <strong>preverite</strong>, ali so naložene datoteke pravilne, in <strong>omogočite</strong> razširitev, če bi jo še vedno morali uporabljati na plošči.',

	'ACP_UPLOAD_EXT_NO_CHECKSUM_TITLE'	=> 'Za naloženo datoteko ni bila podana nobena kontrolna vsota.',
	'ACP_UPLOAD_EXT_NO_CHECKSUM'		=> 'Nalaganje razširitev niso mogle izvesti varnostnih preverjanj, ker <strong>kontrolna vsota ni bila podana</strong> za naloženo datoteko zip. Kontrolna vsota se uporablja za zagotovitev, da naložena datoteka ni poškodovana in ogrožena.',

	'VALID_PHPBB_EXTENSIONS'			=> 'Potrjene razširitve',
	'SHOW_VALID_PHPBB_EXTENSIONS'		=> 'Pokaži potrjene razširitve',
	'VALID_PHPBB_EXTENSIONS_TITLE'		=> 'Preverjene razširitve lahko prenesete iz CDB na phpbb.com ali si ogledate njihove domače strani.',
	'VALID_PHPBB_EXTENSIONS_EMPTY_LIST'	=> 'Trenutno ni predlaganih nobenih razširitev. Preverite posodobitve za Nalaganje razširitev.',
	'POSSIBLE_SOLUTIONS'				=> 'Možne rešitve',

	'ACP_UPLOAD_EXT_MANAGER_EXPLAIN'	=> 'Upravitelj razširitev Nalaganje razširitev je orodje v vaši plošči phpBB, ki vam omogoča upravljanje vseh vaših razširitev in ogled informacij o njih.',
	'ACP_UPLOAD_ZIP_TITLE'				=> 'Upravljanje datotek ZIP',
	'ACP_UPLOAD_UNINSTALLED_TITLE'		=> 'Izbrišite razširitve',

	'EXT_DETAILS_README'				=> 'Preberi me',
	'EXT_DETAILS_CHANGELOG'				=> 'Dnevnik sprememb',
	'EXT_DETAILS_LANGUAGES'				=> 'Jeziki',
	'EXT_DETAILS_FILETREE'				=> 'Datotečno drevo',
	'EXT_DETAILS_TOOLS'					=> 'Orodja',

	'DEFAULT'							=> 'privzeto',
	'EXT_LANGUAGE_ISO_CODE'				=> 'ISO koda',
	'EXT_LANGUAGES'						=> 'Naloženi jezikovni paketi',
	'EXT_LANGUAGES_UPLOAD'				=> 'Naložite jezikovni paket',
	'EXT_LANGUAGES_UPLOAD_EXPLAIN'		=> 'Tukaj lahko naložite stisnjen paket, ki vsebuje potrebne jezikovne datoteke za to razširitev iz vašega lokalnega računalnika ali oddaljenega strežnika. “Nalaganje razširitve” bo nato poskušal razpakirati datoteke in jih premakniti na pravo mesto.<br />Izberite datoteko ali vnesite povezavo v spodnja polja.<br />Ne pozabite določiti kode ISO jezika v spodnje ustrezno polje (primer: <strong>en</strong>).<br /><strong>POMEMBNO!</strong> Jezikovni imenik vaše trenutne razširitve s to kodo ISO bo izbrisan, če obstaja, <strong>za to ne bo narejen zip arhiv</strong>.',
	'EXT_LANGUAGE_UPLOADED'				=> 'Jezikovni paket “%s” je bil uspešno naložen.',
	'EXT_LANGUAGE_DELETE_CONFIRM'		=> 'Ali ste prepričani, da želite izbrisati jezikovni paket “%s”?',
	'EXT_LANGUAGES_DELETE_CONFIRM'		=> array(
		2	=> 'Ali ste prepričani, da želite izbrisati jezikovne pakete <strong>%1$s</strong>?',
	),
	'EXT_LANGUAGE_DELETE_SUCCESS'		=> 'Jezikovni paket razširitve je bil uspešno izbrisan.',
	'EXT_LANGUAGES_DELETE_SUCCESS'		=> 'Jezikovni paketi razširitve so bili uspešno izbrisani.',
	'EXT_LANGUAGE_DELETE_ERROR'			=> 'Nobena datoteka ni določena ali pa je med brisanjem prišlo do napake.',

	'EXT_TOOLS_DOWNLOAD_TITLE'			=> 'Prenesite zapakirano razširitev',
	'EXT_TOOLS_DOWNLOAD'				=> 'Na svoj računalnik lahko prenesete pravilno zapakirano ZIP datoteko razširitve. Izbrišete lahko tudi pripono razvojne različice (npr. za skrajšanje časa za pripravo razširitve za CDB).',
	'EXT_TOOLS_DOWNLOAD_DELETE_SUFFIX'	=> 'Izbrišite razvojno pripono, če obstaja',
	'EXT_DOWNLOAD_ERROR'				=> 'Poskus prenosa razširitve “%s” ni uspel.',

	'EXT_LOAD_ERROR'					=> 'Napaka pri nalaganju',
	'EXT_LOAD_TIMEOUT'					=> 'Nalaganje se je izteklo',
	'EXT_LOAD_ERROR_EXPLAIN'			=> 'Med postopkom nalaganja je prišlo do napake.',
	'EXT_LOAD_ERROR_SHOW'				=> 'Pokaži nastale napake',
	'EXT_LOAD_SOLUTIONS'				=> 'Preverite datoteke dnevnika napak na vašem strežniku, odpravite težavo in poskusite znova.',

	'UPLOAD_DESCRIPTION_UPLOAD'			=> 'Naložite phpBB razširitve',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'		=> 'CDB na phpbb.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'	=> 'Lokalni PC',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'	=> 'Oddaljeni strežnik',
	'UPLOAD_DESCRIPTION_UPDATE'			=> 'Posodobite phpBB razširitve',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'	=> 'Posodobite lahko katero koli od že naloženih razširitev. Razširitev, ki jo želite posodobiti, bo samodejno onemogočena, tako da bodo vse posodobitve varne.',
	'UPLOAD_DESCRIPTION_MANAGE'			=> 'Upravljajte phpBB razširitve',
	'UPLOAD_DESCRIPTION_MANAGE_ACTIONS'	=> 'Namestite/Odstranite katerokoli razširitve',
	'UPLOAD_DESCRIPTION_MANAGE_LANG'	=> 'Prenesite in upravljajte jezikovne pakete razširitev',
	'UPLOAD_DESCRIPTION_MANAGE_DETAILS'	=> 'Oglejte si podrobnosti in datotečna drevesa',
	'UPLOAD_DESCRIPTION_DESIGN'			=> 'Interaktivni vmesnik',
	'UPLOAD_DESCRIPTION_DESIGN_ABOUT'	=> 'Dejanja lahko izvajate hitreje zaradi funkcionalnosti JavaScript. Barvita sporočila in namigi vam bodo pomagali pri pravilnih odločitvah.',
	'UPLOAD_DESCRIPTION_ZIP'			=> 'Upravljanje datotek ZIP',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'		=> 'Zip shranite v imenik po vaši izbiri',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'		=> 'Razpakirajte datoteko zip, da namestite razširitev',
	'UPLOAD_DESCRIPTION_ZIP_DOWNLOAD'	=> 'Prenesite ustrezne zip pakete razširitev',
	'UPLOAD_DESCRIPTION_CLEANER'		=> 'Orodje za Čiščenje razširitev',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'	=> 'Iz strežnika lahko izbrišete imenike razširitev ali zip datoteke razširitev.',
));
