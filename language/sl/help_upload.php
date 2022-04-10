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

// Some characters you may want to copy&paste:
// ’ » “ ” …

$help = array(
	array(
		0 => '--',
		1 => 'Splošni moduli'
	),
	array(
		0 => 'Kaj lahko storim s funkcijo “Naloži razširitev”?',
		1 => 'Razširitve lahko naložite iz različnih virov, ne da bi morali uporabiti odjemalca FTP. Ko naložite razširitev, ki že obstaja na vaši plošči, se njena stara različica samodejno shrani v določen imenik na vaši plošči - preverite modul “Upravljanje datotek ZIP”. Prav tako lahko shranite zip datoteko trenutno naložene različice razširitve - pred postopkom nalaganja označite zastavico “Shrani naloženo zip datoteko”. Prepričajte se, da ste naložili zip paket prave razširitve, če v ustreznem polju obrazca navedete njegovo kontrolno vsoto.'
	),
	array(
		0 => 'Kakšna je razlika med “Upraviteljem razširitev razširitev za nalaganje” in standardnim “Upraviteljem razširitev”?',
		1 => 'Tako kot standardni “Upravitelj razširitev” je “Upravitelj razširitev razširitev za nalaganje” orodje v vaši plošči phpBB, ki vam omogoča upravljanje vseh vaših razširitev in ogled informacij o njih. Lahko pa se določi kot “nadgrajena različica” standardnega modula.<br /><br /><strong>Ključne prednosti:</strong><ul><li>Vse naložene razširitve so razvrščene po abecedi, ne glede na to, ali so omogočeni, onemogočeni ali odstranjeni. Izjema: pokvarjene razširitve.</li><li>Pokvarjene razširitve so prikazane ločeno na isti strani “Upravitelj razširitev” pod seznamom običajnih razširitev. Razlogi za nerazpoložljivost so prikazani za vsako pokvarjeno razširitev. Tem razlogom je dodano podrobno opozorilo, ko je nameščena pokvarjena razširitev ali ima nekaj podatkov shranjenih v vaši bazi podatkov. Lahko kliknete vrstico katere koli pokvarjene razširitve, da si ogledate njene podrobnosti na enak način, kot velja za druge razširitve.</li><li>Vsako razširitev (če ni pokvarjena) je mogoče omogočiti z eno samo razširitvijo. kliknite na preklop, prikazan na levi strani njegovega imena na seznamu.</li></ul>'
	),
	array(
		0 => 'Zakaj potrebujem modul “Upravljanje datotek ZIP”.?',
		1 => 'Včasih se vam zdi koristno, če lahko shranite arhive svojih razširitev ali jih delite. Arhivi so lahko stare različice naloženih razširitev (ki so samodejno pakirane zaradi varnosti podatkov), vsi paketi, ki ste jih izbrali za shranjevanje tako, da označite zastavico “Shrani naloženo zip datoteko” pred postopkom nalaganja ali katere koli datoteke zip razširitev, ki so shranjene v določenem imeniku (glejte vprašanje “Kje lahko določim imenik za shranjevanje datotek zip razširitev?” spodaj). Imate možnosti za razpakiranje, prenos in brisanje teh paketov.'
	),
	array(
		0 => 'Kako lahko uporabim modul “Izbriši razširitve”.?',
		1 => '“Delete extensions” modul vam omogoča, da odstranite datoteke nenameščenih razširitev s strežnika, tako da lahko dokončate popolno odstranitev brez uporabe FTP. Ko razširitve ne potrebujete več, jo lahko popolnoma odstranite s plošče. Če želite to narediti, morate izvesti naslednje korake:<ul><li>Najprej se prepričajte, da res ne potrebujete posebne razširitve. Priporočljivo je, da pred kakršnimi koli odstranitvami naredite nekaj varnostnih kopij datotek in baze podatkov.</li><li>Nato se pomaknite do “Upravitelj razširitev razširitev za nalaganje”, poiščite razširitev, ki jo želite izbrisati, in se prepričajte, da je onemogočena: kliknite stikalo te razširitve <em>če je preklop zelene barve</em>.</li ><li>Prepričajte se, da so podatki razširitve izbrisani: <em>če je prikazan gumb za smeti te razširitve</em>, ga kliknite in potrdite svoje dejanje.</li><li>Po tem se pomaknite do “Izbriši razširitve”, kliknite na povezavo “Izbriši razširitev”, prikazano v vrstici vaše razširitve, in potrdite svoje dejanje.</li></ul>'
	),
	array(
		0 => '--',
		1 => 'Postopek nalaganja'
	),
	array(
		0 => 'Kako lahko naložim potrjene razširitve iz CDB na phpbb.com?',
		1 => 'Na glavni strani Naloži razširitve kliknite povezavo “Pokaži preverjene razširitve”. Izberite razširitev, ki jo želite naložiti, in kliknite gumb “Prenesi” v vrstici te razširitve. Opomba: igra besed tukaj: razširitev bo <em>prenesena</em> iz oddaljenega vira in <em>naložena</em> na vaš strežnik.'
	),
	array(
		0 => 'Kako lahko izvedem nalaganje iz drugih oddaljenih virov?',
		1 => 'Kopirajte <strong>neposredno</strong> povezavo do zip paketa razširitve (če povezava ni s spletnega mesta phpbb.com, se mora končati s <code>.zip</code>) v namensko polje obrazca “Naloži razširitev” in kliknite gumb “Naloži”.'
	),
	array(
		0 => 'Kako lahko naložim razširitev iz lokalnega PC?',
		1 => 'Če želite to narediti, kliknite gumb “Prebrskaj ...” v obrazcu “Naloži razširitev”, izberite zip datoteko razširitve na vašem računalniku in nato kliknite gumb “Naloži”.'
	),
	array(
		0 => 'Povezavo do zip paketa razširitve sem kopiral v polje in kliknil gumb “Naloži”, vendar vidim napako. Kaj je narobe s povezavo?',
		1 => 'Če želite naložiti razširitev, se prepričajte, da so izpolnjeni naslednji pogoji:<ol><li>Povezava mora biti <strong>neposredna</strong>: za nalaganje iz virov, ki niso phpbb.com, mora imeti <code>.zip</code> na koncu.</li><li>Povezava mora voditi do <strong>zip datoteke</strong> razširitve, ne pa do njene opisne strani.</li></ol>'
	),
	array(
		0 => 'Kaj je kontrolna vsota? Kam ga lahko vzamem?',
		1 => 'Kontrolna vsota se uporablja za preverjanje celovitosti naložene datoteke. Preverjeno je, da se zagotovi, da sta datoteka na oddaljenem strežniku in datoteka, naložena na vaš strežnik, enaki. Kontrolno vsoto je običajno mogoče pridobiti iz istega vira, kjer je shranjena izvirna datoteka.'
	),
	array(
		0 => '--',
		1 => 'Upravitelj razširitev Razširitev za nalaganje'
	),
	array(
		0 => 'Kako uporabljati “Upravitelj razširitev Razširitev za nalaganje”?',
		1 => 'Stanje vsake razširitve je prikazano kot preklop.<ul><li>Zeleno stikalo pomeni, da je razširitev omogočena. Ko kliknete zeleno stikalo, bo razširitev <strong>onemogočena</strong>.</li><li>Rdeča stikala pomeni, da je razširitev onemogočena. Ko kliknete rdeč preklop, bo razširitev <strong>omogočena</strong>.</li><li>Če je razširitev, ki ima rdeč preklop, onemogočena, vendar so v zbirki podatkov shranjeni nekateri podatki razširitve, potem bo imel možnost izbrisati svoje podatke s klikom na koš za smeti blizu stikala.<br /><em>Klik na koš za smeti je način za odstranitev razširitve iz baze podatkov. Če želite datoteke razširitve izbrisati iz strežnika, boste morali uporabiti orodje Čistilo za razširitve.</em></li></ul><br />Prav tako lahko znova preverite vse različice razširitev. s klikom na ustrezen gumb ali nastavite nastavitve preverjanja različice, tako kot v standardnem “Upravitelju razširitev”.'
	),
	array(
		0 => 'Kaj pa pokvarjeni podaljški? Ali jih lahko odstranim?',
		1 => 'Ja seveda! Pokvarjene razširitve so prikazane v “Upravitelj razširitev Razširitev za nalaganje” pod seznamom običajnih razširitev. Ogledate si lahko razloge, zakaj so te razširitve pokvarjene in ali imajo nekatere podatke shranjene v vaši bazi podatkov. Kliknite vrstico pokvarjene razširitve, da si ogledate njene podrobnosti in jo upravljate.'
	),
	array(
		0 => 'Gumb za preklop razširitve je siv. Zakaj?',
		1 => 'Sivi preklopni gumb pomeni, da s to razširitvijo trenutno ne morete izvajati nobenih dejanj. Verjetno je že v teku druga akcija. Prav tako se razširitve za nalaganje ne morejo onemogočiti - zato je tudi njen gumb siv.'
	),
	array(
		0 => '--',
		1 => 'Stran s podrobnostmi o razširitvi'
	),
	array(
		0 => 'Katere informacije so prikazane za moje razširitve?',
		1 => 'Prikazane informacije so odvisne od več okoliščin.<ul><li>Splošni opis, ki ga zagotovijo razvijalci razširitve v datoteki <code>composer.json</code> (ali opozorilno sporočilo, če je razširitev pokvarjena).</li><li> Številka različice razširitve (če ni poškodovana).</li><li>Vsebina datoteke <code>README.md</code> (če obstaja v imeniku razširitve).</li> <li>Vsebina datoteke <code>CHANGELOG.md</code> (če obstaja v imeniku razširitve).</li><li>Naloženi jezikovni paketi za razširitev.</li><li>Naloženi jezikovni paketi za razširitev. drevo datotek za razširitev in vsebino njenih datotek.</li></ul>'
	),
	array(
		0 => 'Kaj lahko storim z razširitvijo na strani s podrobnostmi?',
		1 => 'Lahko:<ul><li>Omogočite razširitev, če je njen preklop rdeč.</li><li>Onemogočite razširitev, če je njen preklop zelen.</li><li>Podatke razširitve izbrišete iz baze podatkov, če je vklopljen, če je preklopnik rdeč. prikazan je rdeči gumb za koš za smeti.</li><li>Preverite stanje trenutne različice razširitve, če so povezavo do datoteke za preverjanje različice zagotovili razvijalci razširitve. Če je različica razširitve prikazana v zelenem oblačku - razširitev je posodobljena. Če je mehurček rdeč - razširitev ni posodobljena. V nasprotnem primeru – informacij o preverjanju različice ni bilo mogoče pridobiti.</li><li>Prejmite posodobitev za razširitev, če vidite zobato kolo blizu oblačka različice razširitve. Kliknite na zobato kolo: če je prikazan gumb “Posodobi” - ga lahko kliknete, potrdite svoje dejanje in razširitve za nalaganje bodo posodobile vašo razširitev. Obvestilo o izdaji si lahko ogledate tudi s klikom na ustrezen gumb, če povezavo zagotovijo razvijalci razširitev. <strong>OPOMBA:</strong> če je JavaScript onemogočen v vašem brskalniku, bodo ti gumbi v bloku razdelka s podrobnostmi razširitve.</li><li>Upravljajte jezikovne pakete razširitve. Za razširitev lahko naložite nov jezikovni paket – (glejte vprašanje “Katere jezikovne pakete lahko naložim za razširitev?” spodaj. Izbrišete lahko tudi nekatere že nameščene jezikovne pakete.</li><li>Prenesite paket razširitve (glejte vprašanje “Kaj je namen funkcije “Prenesi pakirano razširitev”?” spodaj)</li></ul>'
	),
	array(
		0 => 'Katere jezikovne pakete lahko naložim za razširitev?',
		1 => 'Naložite lahko poljubne pakete zip, ki vsebujejo jezikovne datoteke za razširitev, če imajo ti paketi eno od naslednjih struktur:<ul><li><code>ZIP_FILE_ROOT/language_files</code> ali</li><li><code >ZIP_FILE_ROOT/single_directory/language_files</code> ali</li><li><code>ZIP_FILE_ROOT/single_directory/language_ISO_code/language_files</code>.</li></ul><br />Za več informacij o postopek nalaganja glejte zgornji razdelek “Postopek nalaganja”.'
	),
	array(
		0 => 'Kaj je namen funkcije “Prenesi pakirano razširitev”?',
		1 => 'Nalaganje razširitev vam omogoča prenos ustreznih zip paketov vseh naloženih razširitev na vaši plošči na vaš lokalni računalnik. Označite lahko tudi zastavico, da izbrišete pripono razvojne različice – to dejanje vam lahko pomaga na primer, da skrajšate čas za pripravo razširitve za CDB. Pomaknite se na stran s podrobnostmi o razširitvi in kliknite gumb razdelka “Orodja”. Nato se prikaže gumb “Prenesi”.'
	),
	array(
		0 => '--',
		1 => 'Upravljanje datotek ZIP'
	),
	array(
		0 => 'Kje lahko določim imenik za shranjevanje zip datotek razširitev?',
		1 => 'V ANP se pomaknite do <code>Splošno -> Konfiguracija strežnika -> Nastavitve strežnika -> Nastavitve poti -> Pot shranjevanja paketov zip razširitev</code>.'
	),
	array(
		0 => 'Kako lahko izbrišem zip pakete več razširitev hkrati?',
		1 => 'Najprej se prepričajte, da resnično morate izvesti takšno dejanje; priporočljivo je, da naredite potrebne varnostne kopije. Nato se pomaknite do modula “Upravljanje datotek ZIP”, označite zastavice v vrsticah zip paketov, ki jih želite izbrisati, kliknite gumb “Izbriši označeno” in potrdite svoje dejanje.'
	),
	array(
		0 => '--',
		1 => 'Orodje za čiščenje razširitev'
	),
	array(
		0 => 'Kaj je “Orodje za čiščenje razširitev”?',
		1 => '“Orodje za čiščenje razširitev” je ime modula “Izbriši razširitve” razširitev za nalaganje, ki se včasih uporablja v njegovi dokumentaciji.'
	),
	array(
		0 => 'Na moji plošči je nameščena razširitev, vendar je ne morem izbrisati. Zakaj?',
		1 => 'Razširitev, ki jo želite odstraniti, je treba onemogočiti in njene podatke izbrisati iz baze podatkov, preden uporabite “Orodje za čiščenje razširitev”. Glejte vprašanje “Kako lahko uporabim modul “Izbriši razširitve”?” zgoraj.'
	),
	array(
		0 => 'Kako lahko izbrišem več razširitev hkrati?',
		1 => 'Najprej se prepričajte, da resnično morate izvesti takšno dejanje; priporočljivo je, da naredite potrebne varnostne kopije. Nato se pomaknite do modula “Izbriši razširitve”, označite zastavice v vrsticah razširitev, ki jih želite izbrisati, kliknite gumb “Izbriši označene” in potrdite svoje dejanje. <strong>Te razširitve ne bodo shranjene kot zip datoteke! Njihovi imeniki bodo v celoti odstranjeni iz strežnika.</strong>'
	),
	array(
		0 => '--',
		1 => 'Interaktivni vmesnik'
	),
	array(
		0 => 'Kakšne so prednosti funkcionalnosti JavaScript?',
		1 => 'Strani se nalagajo hitreje, elementi oblikovanja se hitro spreminjajo, ko komunicirate z njimi, v pomoč so vam namigi orodij. Vse te funkcije prihranijo vaš čas in so na voljo le, če je v vašem brskalniku omogočen JavaScript.'
	),
);
