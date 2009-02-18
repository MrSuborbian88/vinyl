<?php
/// Please, do not edit this file manually! It's auto generated from
/// contents stored in your standard lang pack files:
/// (langconfig.php, install.php, moodle.php, admin.php and error.php)
///
/// If you find some missing string in Moodle installation, please,
/// keep us informed using http://moodle.org/bugs Thanks!
///
/// File generated by cvs://contrib/lang2installer/installer_builder
/// using strings defined in stringnames.txt (same dir)

$string['admindirerror'] = 'Specificirani administratorski direktorijum je netačan';
$string['admindirname'] = 'Administratorski direktorijum';
$string['admindirsettinghead'] = 'Podešavanje administratorskog direktorijuma';
$string['admindirsettingsub'] = 'Poneki Web serveri koriste /admin kao specijalni URL za pristup raznim podešavanjima ili nečem drugom. Nažalost to je u konfliktu sa standardnom Moodle lokacijom za administratorske stranice. Možete rešiti problem preimenovanjem administratorskog direktorijuma u Vašoj instalaciji, i navođenjem tog novog naziva ovde. Na primer: <br /> <br /><b>moodleadmin</b><br /> <br />
Ovo podešavanje će prepraviti administratorske linkove u Moodle sistemu.';
$string['bypassed'] = 'Izbegnuto';
$string['cannotcreatelangdir'] = 'Nije moguće kreiranje direktorijuma jezika';
$string['cannotcreatetempdir'] = 'Nije moguće kreiranje privremenog direktorijuma.';
$string['cannotdownloadcomponents'] = 'Nije moguće preuzimanje komponenti.';
$string['cannotdownloadzipfile'] = 'Nije moguće preuzimanje arhive.';
$string['cannotfindcomponent'] = 'Nije moguće pronalaženje komponenti.';
$string['cannotsavemd5file'] = 'Nije moguće čuvanje md5 datoteke.';
$string['cannotsavezipfile'] = 'Nije moguće čuvanje arhive.';
$string['cannotunzipfile'] = 'Nije moguće raspakivanje datoteke.';
$string['caution'] = 'Oprez';
$string['check'] = 'Proveri';
$string['chooselanguagehead'] = 'Izaberite jezik';
$string['chooselanguagesub'] = 'Molimo izaberite jezik koji će se koristiti samo tokom instalacije. Kasnije ćete moći da izaberete jezička podešavanja na nivou sajta i korisnika.';
$string['closewindow'] = 'Zatvorite ovaj prozor';
$string['compatibilitysettingshead'] = 'Provera Vaših PHP podešavanja...';
$string['compatibilitysettingssub'] = 'Vaš server bi trebao proći sve ove testove da bi Moodle na njemu uspešno funkcionisao';
$string['componentisuptodate'] = 'Komponenta je dostupna u svojoj najnovijoj verziji.';
$string['configfilenotwritten'] = 'Instalacioni skript nije bio u mogućnosti da automatski kreira datoteku config.php koja bi sadržavala Vaša odabrana podešavanja, verojatno zbog toga što nema prava na pisanje (menjanje sadržaja) u Vašem Moodle direktorijumu. Ako to želite, možete ručno kopirati kod u datoteku config.php u osnovnom direktorijumu Vaše Moodle instalacije.';
$string['configfilewritten'] = 'config.php je uspešno kreiran';
$string['configurationcompletehead'] = 'Konfiguracija je završena';
$string['configurationcompletesub'] = 'Moodle je pokušao da sačuva Vašu konfiguraciju u datoteci smeštenoj u korenskom direktorijumu Moodle instalacije.';
$string['continue'] = 'Nastavak';
$string['ctyperecommended'] = 'Instaliranje opcione PHP ekstenzije ctype se strogo preporučuje da bi se unapredilo funkcionisanje sajta, pogotovo ako Vaš sajt podržava ne-latinične jezike.';
$string['ctyperequired'] = 'PHP ekstenzije ctype je sada obavezna za Moodle, da bi se unapredilo funkcionisanje sajta i da bi se nudila višejezična kompatibilnost.';
$string['curlrecommended'] = 'Instaliranje opcione Curl biblioteke je vrlo preporučljivo, jer je ona neophodna za uspešno korišćenje funkcija za umrežavanje.';
$string['curlrequired'] = 'PHP ekstenziju cURL sada je obavezna za Moodle da bi se komuniciralo sa Moodle repozitorijumima';
$string['customcheck'] = 'Druge provere';
$string['database'] = 'Baza podataka';
$string['databasecreationsettingshead'] = 'Sada je potrebno konfigurisati podešavanja baze podataka u kojoj će se čuvati najveći deo Moodle podataka. Ta baza podataka će biti kreirana automatski prilikom instalacije, sa podešavanjima specificiranim ispod.';
$string['databasecreationsettingssub'] = '<b>Tip:</b> postavljeno na \"mysql\" prilikom instalacije<br />
<b>Server:</b> postavljeno na \"localhost\" prilikom instalacije<br />
<b>Naziv:</b> naziv baze podataka, npr. moodle<br />
<b>Korisnik:</b> postavljeno na \"root\" prilikom instalacije<br />
<b>Lozinka:</b> Vaša lozinka za bazu podataka<br />
<b>Prefiks tabela:</b> opcioni prefiks koji će se koristiti u nazivima svih tabela';
$string['databasesettingshead'] = 'Sada je potrebno konfigurisati bazu podataka u kojoj će se čuvati veći deo Moodle podataka. Ta baza podataka mora već biti kreirana, kao i korisničko ime i lozinka za pristup istoj.';
$string['databasesettingssub'] = '<b>Tip:</b> mysql ili postgres7<br />
<b>Server:</b> npr. localhost ili db.isp.com<br />
<b>Naziv:</b> naziv baze podataka, npr. moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiks tabela:</b> opcioni prefiks koji će se koristiti u nazivima svih tabela';
$string['databasesettingssub_mssql'] = '<b>Tip:</b> SQL* Server (koji nije UTF-8) <b><font color=\"red\">Eksperimentalan! (nije za javni pristup)</font></b><br />
<b>Server:</b> npr localhost ili db.isp.com<br />
<b>Naziv:</b> naziv baze podataka, npr moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiks tabela:</b> prefiks koji će se koristiti u nazivima svih tabela (obavezno)';
$string['databasesettingssub_mssql_n'] = '<b>Tip:</b> SQL* Server (UTF-8 omogućen)<br />
<b>Server:</b> npr localhost ili db.isp.com<br />
<b>Naziv:</b> naziv baze podataka, npr moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi odataka<br />
<b>Prefiks tabela:</b> prefiks koji će se koristiti u nazivima svih tabela (obavezno)';
$string['databasesettingssub_mysql'] = '<b>Tip:</b> MySQL<br />
<b>Server:</b> npr localhost ili db.isp.com<br />
<b>Naziv:</b> naziv baze podataka, npr moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiksi tabela:</b> prefiks koji će se  koristiti u nazivima svih tabela (opciono)';
$string['databasesettingssub_mysqli'] = '<b>Tip:</b> Unapređeni MySQL<br />
<b>Host:</b> npr. localhost ili db.isp.com<br />
<b>Ime:</b> ime baze podataka, npr. moodle<br />
<b>Korisnik:</b> Korisničko ime za Vašu bazu podataka<br />
<b>Password:</b> Lozinka korisnika Vaše  baze podataka<br />
<b>Prefiks za tabele:</b> prefiks koji se dodaje ispred imena svih tabela (nije obavezno)';
$string['databasesettingssub_oci8po'] = '<b>Tip:</b> Oracle<br />
<b>Server:</b> ne koristi se, mora se ostaviti prazno<br />
<b>Naziv:</b> ime koje ste dali tnsnames.ora konekciji<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiksi tabela:</b> prefiks koji će se koristiti u nazivima svih tabela (obavezno, maksimalno 2 vidljive kopije)';
$string['databasesettingssub_odbc_mssql'] = '<b>Tip:</b> SQL* Server (preko ODBC) <b><font color=\"red\">Eksperimentalno! (nije za javni pristup)</font></b><br />
<b>Server:</b> ime koje ste dali DSN-u u ODBC kontrolnom panelu<br />
<b>Naziv:</b> naziv baze podataka, npr moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Password:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiksi tabela:</b> prefiks koji će se koristiti u nazivima svih tabela (obavezno)';
$string['databasesettingssub_postgres7'] = '<b>Tip:</b> PostgreSQL<br />
<b>Server:</b> npr localhost ili db.isp.com<br />
<b>Naziv:</b> naziv baze podataka, npr moodle<br />
<b>Korisnik:</b> Vaše korisničko ime za pristup bazi podataka<br />
<b>Lozinka:</b> Vaša lozinka za pristup bazi podataka<br />
<b>Prefiksi tabela:</b> prefiks koji će se koristiti u nazivima svih tabela (obavezno)';
$string['databasesettingswillbecreated'] = '<b>Napomena:</b> Program ѕa instalaciju će automatski pokušati da kreira bazu podataka ukoliko ona ne postoji.';
$string['dataroot'] = 'Direktorijum podataka';
$string['datarooterror'] = '\'Direktorijum podataka\' koji ste naveli ne može biti pronađen ili kreiran. Unesite tačnu putanju ili napravite taj direktorijum ručno.';
$string['datarootpublicerror'] = '\'Direktorijum za podatke\' koji ste podesili je direktno dostupan sa Weba, morate koristiti drugi direktorijum.';
$string['dbconnectionerror'] = 'Nemoguće je uspostaviti vezu sa bazom podataka koju ste naveli. Molimo proverite podešavanja baze podataka.';
$string['dbcreationerror'] = 'Greška pri kreiranju baze podataka. Nije bilo moguće kreirati bazu navedenog imena uz zadata podešavanja';
$string['dbhost'] = 'Server';
$string['dbprefix'] = 'Prefiks tabele';
$string['dbtype'] = 'Tip';
$string['dbwrongencoding'] = 'Izabrana baza podataka radi pod nepreporučljivim kodnim rasporedom ($a). Bilo bi bolje da umesto nje koristite Unicode (UTF-8) kodiranu bazu. U svakom slučaju, možete izbeći ovaj test biranjem opcije \"Preskočiti test kodnog rasporeda baze podataka\" ispod, ali se u budućnosti možete suočiti sa problemima pri korišćenju izabrane baze.';
$string['dbwronghostserver'] = 'Morate pratiti pravila \"Servera\" kao što je objašnjeno iznad.';
$string['dbwrongnlslang'] = 'NLS_LANG promenljiva okruženja Vašeg web servera mora da koristi AL32UTF8 skup karaktera. Pogledajte PHP dokumentaciju o tome kako da pravilno podesite OCI8.';
$string['dbwrongprefix'] = 'Morate pratiti pravila \"Prefiksi tabela\" kao što je gore objašnjeno.';
$string['directorysettingshead'] = 'Molimo potvrdite lokacije ove Moodle instalacije';
$string['directorysettingssub'] = '<b>Web adresa:</b>
Specificirajte potpunu web adresu na kojoj će se pristupati Moodle sistemu.
Ako je Vašem web sajtu moguće pristupiti preko više URL-ova, izaberite onaj koji će najverovatnije koristiti Vaši studenti. Nemojte navoditi krajnju kosu crtu.
<br />
<br />
<b>Moodle direktorijum:</b>
Specificirajte potpunu putanju do ove instalacije
Vodite računa o velikim i malim slovima.
<br />
<br />
<b>Direktorijum podataka:</b>
Morate odrediti mesto na kom će Moodle čuvati postavljene datoteke. Korisnik web servera (obično \'niko\' ili \'apache\') bi morao imati mogućnost da čita podatke iz tog direktorijuma, ali i da ih u njega upisuje, ali oni ne bi trebali biti dostupni direktno preko web-a.';
$string['dirroot'] = 'Moodle direktorijum';
$string['dirrooterror'] = 'Podešavanje \'Moodle direktorijuma\' je čini se netačno - ne može se tamo naći Moodle instalacija. Niža vrednost će biti ponovo dovedena na početni položaj.';
$string['download'] = 'Preuzeti';
$string['downloadedfilecheckfailed'] = 'Nije uspela provera preuzete datoteke.';
$string['downloadlanguagebutton'] = 'Preuzmi \"$a\" jezički paket';
$string['downloadlanguagehead'] = 'Preuzmi jezički paket';
$string['downloadlanguagenotneeded'] = 'Možete nastaviti proces instalacije korišćenjem podrazumevanog jezičkog paketa, \"$a\".';
$string['downloadlanguagesub'] = 'Sada imate mogućnost preuzimanja željenog jezičkog paketa i nastavka instalacionog procesa na tom jeziku.<br /><br />Ako niste u mogućnosti da preuzmete jezički paket, instalacioni proces će se nastaviti na engleskom jeziku. (Kada se instalacija završi, imaćete mogućnost da preuzmete i instalirate dodatne jezičke pakete.)';
$string['environmenterrortodo'] = 'Morate rešiti sve probleme okruženja (greške) navedene iznad pre nastavka instalacije ove Moodle verzije!';
$string['environmenthead'] = 'Proveravanje Vašeg okruženja...';
$string['environmentrecommendcustomcheck'] = 'ukoliko ovaj test ne prođe, postoji mogućnost pojavljivanja potencijalnog problema.';
$string['environmentrecommendinstall'] = 'je preporučljivo instalirati/omogućiti';
$string['environmentrecommendversion'] = 'preporučena verzija je $a->needed a Vi trenutno koristite verziju $a->current';
$string['environmentrequirecustomcheck'] = 'Ovaj test mora proći';
$string['environmentrequireinstall'] = 'je neophodno instalirati/omogućiti';
$string['environmentrequireversion'] = 'neophodna verzija je $a->needed a Vi trenutno koristite verziju $a->current';
$string['environmentsub'] = 'Proverava se da li razne komponente Vašeg sistema zadovoljavaju sistemske zahteve';
$string['environmentxmlerror'] = 'Greška u čitanju podataka okruženja ($a->error_code)';
$string['error'] = 'Greška';
$string['fail'] = 'Nije prošlo';
$string['fileuploads'] = 'Postavljanje datoteka';
$string['fileuploadserror'] = 'Ova opcija bi trebala biti uključena';
$string['fileuploadshelp'] = '<p>Postavljanje datoteka je izgleda nedostupno na Vašem serveru.</p>

<p>Moodle još uvek može biti instaliran, ali bez ove mogućnosti, nećete biti u mogućnosti da učitavate datoteke kursa ili nove slike za korisničke profile.</p>

<p>Da učitavanje datoteke bude dostupno Vi (ili Vaš sistem administrator) treba da promenite php.ini datoteku na Vašem sistemu i postavite podešavanje za <b>file_uploads</b> na \'1\'.</p>';
$string['gdversion'] = 'GD verzija';
$string['gdversionerror'] = 'GD datoteka sa izvornim kodom trebala bi prezentirati proces i kreirati slike';
$string['gdversionhelp'] = '<p>Na Vašem serveru izgleda nije instaliran GD.</p>

<p>GD je biblioteka koju traži PHP da bi dozvolio Moodle sistemu da procesira slike (kao što su ikonice korisničkih profila) i da kreira nove slike (kao što je grafikon prijava na sistem).  Moodle će još raditi i bez GD biblioteke - ove opcije Vam jednostavno neće biti dostupne.</p>

<p>Da biste dodali GD u PHP pod Unix-om, kompajlirajte PHP koristeći --with-gd parametar.</p>

<p>Pod Windows-om obično možete izmeniti php.ini i skinuti oznaku komentara u liniji koja se odnosi na php_gd2.dll.</p>';
$string['globalsquotes'] = 'Nesigurno rukovanje globalnim varijablama';
$string['globalsquoteserror'] = 'Popravite svoja PHP podešavanja: onemogućite register_globals i/ili omogućite magic_quotes_gpc';
$string['globalsquoteshelp'] = '<p>Kombinacija istovremeno onemogućenog podešavanja Magic Quotes GPC i omogućenog Register Globals nije preporučljiva.</p>

<p>Preporučeno podešavanje je <b>magic_quotes_gpc = On</b> i <b>register_globals = Off</b> u Vašoj datoteci php.ini</p>

<p>Ako nemate pristup svojoj php.ini datoteci, možda možete da stavite sledeći red u datoteku pod nazivom .htaccess u Vašem Moodle direktorijumu:
<blockquote>php_value magic_quotes_gpc On</blockquote>
<blockquote>php_value register_globals Off</blockquote>
</p>';
$string['globalswarning'] = 'p><strong>Bezbednosno upozerenje</strong>: da bi funkcionisao ispravno, Moodle zahteva <br />da napravite neke izmene u vašim PHP podešavanjima.<p/><p><em>Morate</em> da postavite <code>register_globals=off</code>.<p>Ovo podešavanje je pod kontrolom vaše <code>php.ini</code>, Apache/IIS <br />konfiguracije ili <code>.htaccess</code> datoteke.</p>';
$string['help'] = 'Pomoć';
$string['iconvrecommended'] = 'Instaliranje opcione ICONV biblioteke je vrlo preporučljivo u cilju unapređivanja performansi sajta, pogotovo ako Vaš sajt podržava jezike koji ne koriste latinično pismo.';
$string['info'] = 'Informacija';
$string['installation'] = 'Instalacija';
$string['invalidmd5'] = 'Neispravna md5 datoteka';
$string['langdownloaderror'] = 'Nažalost jezik \"$a\" nije instaliran. Proces instalacije biće nastavljen na engleskom jeziku.';
$string['langdownloadok'] = 'Jezik \"$a\" je uspešno instaliran. Instalacioni proces će biti nastavljen na ovom jeziku.';
$string['language'] = 'Jezik';
$string['magicquotesruntime'] = 'Magic Quotes vreme izvršavanja';
$string['magicquotesruntimeerror'] = 'Ova opcija bi trebala biti isključena';
$string['magicquotesruntimehelp'] = '<p>Magic Quotes vreme izvršavanja bi trebalo isključiti da Moodle propisno funkcioniše.</p>

<p>Normalno ovo je isključeno po podrazumevanoj vrednosti... pogledajte podešavanje <b>magic_quotes_runtime</b> u svojoj php.ini datoteci.</p>

<p>Ako nemate pristup php.ini datoteci, možda možete da stavite sledeći red u datoteku pod nazivom .htaccess koja se nalazi u Vašem Moodle direktorijumu: <blocquote>php_value magic_quotes_runtime Off</blockquote>
</p>';
$string['mbstringrecommended'] = 'Instaliranje opcione MBSTRING biblioteke je vrlo preporučljivo u cilju unapređivanja performansi sajta, pogotovo ako Vaš sajt podržava jezike koji ne koriste latinično pismo.';
$string['memorylimit'] = 'Ograničenje memorije';
$string['memorylimiterror'] = 'PHP ograničenje memorije je podešeno na prilično nizak nivo... kasnije može doći do problema.';
$string['memorylimithelp'] = '<p>PHP ograničenje memorije za Vaš server je trenutno podešeno na $a.</p>

<p>Ovo može da prouzrokuje kasnije memorijske probleme Vašeg Moodle sistema, posebno ako imate mnogo dozvoljenih modula i/ili mnogo korisnika.</p>

<p>Preporučujemo da konfigurišete PHP sa višim ograničenjem ako je moguće, recimo 16M. Postoji nekoliko načina da se to uradi. Pokušajte:</p><ol>
<li>Ako možete, rekompajlirajte PHP sa <i>--enable-memory-limit</i>. Ovo će dozvoliti Moodle sistemu da postavi memorijsko ograničenje sam za sebe.</li>
<li>Ako imate pristup Vašoj php.ini datoteci, možete promeniti <b>memory_limit</b> podešavanje u recimo 16M. Ako nemate pristup toj datoteci možete pitati svog administratora da to uradi za Vas.</li>
<li>Na nekim PHP serverima možete kreirati .htaccess datoteku u Moodle direktorijumu koja sadrži red:
<p><blockquote>php_value memory_limit 40M</blockquote></p>
<p>Kakogod, na nekim serverima će to sprečiti prikazivanje <b>svih</b> PHP stranica (biće Vam prikazana poruka o grešci umesto svake stranice), pa ćete sa njih morati ukloniti .htaccess datoteku.</p></li>
</ol>';
$string['missingrequiredfield'] = 'Nedostaje neko obavezno polje';
$string['moodledocslink'] = 'Moodle dokumentacija za ovu stranicu';
$string['mssql'] = 'SQL* Server (mssql)';
$string['mssqlextensionisnotpresentinphp'] = 'PHP nije bio propisno konfigurisan sa MSSQL ekstenzijom tako da može komunicirati sa SQL* Serverom. Molimo Vas da proverite svoju php.ini datoteku ili opet kompajlirate PHP.';
$string['mssql_n'] = 'SQL* Server sa UTF-8 podrškom (mssql_n)';
$string['mysql'] = 'MySQL (mysql)';
$string['mysql416bypassed'] = 'Međutim, ako Vaš sajt koristi iso-8859-1 (latin) jezike, možete da nastavite s korišćenjem Vaše trenutno instalirane MySQL verzije 4.1.12 (ili više).';
$string['mysql416required'] = 'MySQL 4.1.16 je minimalna verzija potrebna za Moodle 1.6 da bi se garantovalo dalje konvertovanje svih podataka u UTF-8.';
$string['mysqlextensionisnotpresentinphp'] = 'PHP neće biti propisno konfigurisan sa MySQL ekstenzijom tako da može komunicirati sa MySQL-om. Molimo Vas da proverite svoju php.ini datoteku ili opet kompajlirate PHP.';
$string['mysqli'] = 'Unapređeni MySQL (mysqli)';
$string['mysqliextensionisnotpresentinphp'] = 'PHP nije pravilno podešen za rad sa MySQLi ekstenzijom da bi mogao komunicirati sa MySQL. Molimo proverite Vašu php.ini datoteku ili ponovo kompajlirajte PHP. MySQLi ekstenzija nije na raspolaganju za PHP 4.';
$string['name'] = 'Ime';
$string['next'] = 'Sledeći';
$string['oci8po'] = 'Oracle (oci8po)';
$string['ociextensionisnotpresentinphp'] = 'PHP nije bio propisno konfigurisan sa OCI8 ekstenzijom tako da može komunicirati sa Oracle-om. Molimo Vas da proverite svoju php.ini datoteku ili opet kompajlirate PHP.';
$string['odbcextensionisnotpresentinphp'] = 'PHP nije bio propisno konfigurisan sa ODBC ekstenzijom tako da može komunicirati sa SQL* Serverom. Molimo Vas da proverite svoju php.ini datoteku ili opet kompajlirate PHP.';
$string['odbc_mssql'] = 'SQL* Server preko ODBCa (odbc_mssql)';
$string['ok'] = 'OK';
$string['opensslrecommended'] = 'Instaliranje opcione OpenSSL biblioteke je vrlo preporučljivo -- ona omogućava korišćenje funkcija za umrežavanje.';
$string['parentlanguage'] = '<< PREVODIOCI: Ako Vaš jezik ima nadređeni jezik koji Moodle treba da koristi kada neki izrazi nedostaju Vašem jezičkom paketu, specificirajte njegov kod. Ako ovo polje ostavite prazno biće korišćen engleski jezik. Primer: nl >>';
$string['pass'] = 'Prošlo';
$string['password'] = 'Lozinka';
$string['pgsqlextensionisnotpresentinphp'] = 'PHP nije bio propisno konfigurisan sa  PGSQL ekstenzijom tako da može komunicirati sa PostgreSQLom. Molimo Vas da proverite svoju php.ini datoteku ili opet kompajlirate PHP.';
$string['php50restricted'] = 'PHP 5.0.x ima više poznatih problema, molimo unapredite PHP na verzije 5.1.x ili instalirajte verziju 4.3.x odnosno 4.4.x';
$string['phpversion'] = 'PHP verzija';
$string['phpversionerror'] = 'PHP verzija mora biti bar 4.3.0 ili 5.1.0 (5.0.x funkcioniše uz brojne uočene probleme)'; // ORPHANED
$string['phpversionhelp'] = '<p>Moodle zahteva najmanje PHP verziju 4.3.0 ili 5.1.0 (5.0.x funkcioniše uz brojne uočene probleme).</p>
<p>Trenutno imate verziju $a</p>
<p>Morate nadograditi PHP ili premestiti Moodle instalaciju na web server sa novijom verzijom PHP-a!</br>
(U slučaju verzije 5.0.x bilo bi dobro da je snizite na 4.4.x verziju)</p>';
$string['postgres7'] = 'PostgreSQL (postgres7)';
$string['previous'] = 'Prethodni';
$string['qtyperqpwillberemoved'] = 'Tokom nadogradnje, RQP tipovi pitanja biće uklonjeni. Nećete koristiti ovaj tip pitanja, tako da ne očekujte probleme u vezi s tim.';
$string['qtyperqpwillberemovedanyway'] = 'Tokom nadogradnje biće uklonjen RQP tip pitanja. Kako imate neka RQP pitanja u svojoj bazi, preporučuje se da ponovo instalirate dodatak sa http://moodle.org/mod/data/view.php?d=13&amp;rid=797 pre nastavka nadogradnje da bi ona mogla i dalje nesmetano da se koriste.';
$string['remotedownloaderror'] = 'Preuzimanje komponente na Vaš server nije uspelo. Proverite podešavanja proksi serevera. PHP cURL ekstenzija se preporučuje.<br /><br />Morate da preuzmete <a href=\"$a->url\">$a->url</a> datoteku ručno, kopirate je u direktorijum \"$a->dest\" na svom sereveru tamo je raspakujete.';
$string['remotedownloadnotallowed'] = 'Nije dozvoljeno preuzimanje komponenti na Vaš server (opcija allow_url_fopen je onemogućena).<br /><br />Morate ručno preuzeti datoteku <a href=\"$a->url\">$a->url</a>, kopirati je u \"$a->dest\" na svom serveru i tamo je raspakovati.';
$string['report'] = 'Izveštaj';
$string['restricted'] = 'Ograničeno';
$string['safemode'] = 'Bezbedan mod';
$string['safemodeerror'] = 'Moodle može imati problema sa uključenim bezbednim modom rada';
$string['safemodehelp'] = '<p>Moodle može imati različite probleme sa uključenim bezbednim modom rada, od kojih je jedan od bitnijih taj da najverovatnije neće imati dozvolu da kreira nove datoteke.</p>
   
<p>Bezbedni mod rada je obično jedino dozvoljen na paranoičnim javnim Web serverima, tako da možete prosto naći web server kod neke druge kuće za Vaš Moodle sajt.</p>
   
<p>Možete pokušati nastaviti sa instalacijom ako želite, ali očekujte nekoliko problema kasnije.</p>';
$string['serverchecks'] = 'Provere servera';
$string['sessionautostart'] = 'Automatski početak sesije';
$string['sessionautostarterror'] = 'Ova opcija bi trebala biti isključena';
$string['sessionautostarthelp'] = '<p>Moodle zahteva podršku za sesije i neće funcionisati bez nje.</p>

<p>Rad sa sesijama se može omogućiti u php.ini datoteci... potražite session.auto_start parametar.</p>';
$string['skipdbencodingtest'] = 'Preskočiti test kodnog rasporeda baze podataka';
$string['status'] = 'Status';
$string['thischarset'] = 'UTF-8';
$string['thisdirection'] = 'ltr';
$string['thislanguage'] = 'Srpski';
$string['unicoderecommended'] = 'Preporučljivo je smeštanje vaših podataka u Unikod (UTF-8) standard. Nove instalacije biće izvršene nad bazama koji kao podrazumevan karakter-set imaju podešen Unikod. Ukoliko vršite nadogradnju, potrebno je pokrenuti UTF-8 proces migracije (pogledati Admin stranu).';
$string['unicoderequired'] = 'Potrebno je da sve vaše podatke smeštate u Unikod formatu (UTF-8).Nove instalacije moraju biti primenjene u bazama podataka koje imaju osnovni karakterni set namešten na Unikod. Ukoliko vršite nadogradnju, potrebno je pokrenuti UTF-8 proces migracije (pogledati Admin stranu).';
$string['user'] = 'Korisnik';
$string['welcomep10'] = '$a->installername ($a->installerversion)';
$string['welcomep20'] = 'Prikazana Vam je ova stranica jer ste uspešno instalirali i pokrenuli <strong>$a->packname $a->packversion</strong> paket na Vašem računaru. Čestitamo!';
$string['welcomep30'] = 'Ovo izdanje <strong>$a->installername</strong> uključuje aplikacije za kreiranje okruženja u kom će <strong>Moodle</strong> uspešno funkcionisati, konkretno:';
$string['welcomep40'] = 'Ovaj paket obuhvata i <strong>Moodle $a->moodlerelease ($a->moodleversion)</strong>.';
$string['welcomep50'] = 'Korišćenje aplikacija iz ovog paketa je uslovljeno njhovim licencama. Kompletan <strong>$a->installername</strong> paket je <a href=\"http://www.opensource.org/docs/definition_plain.html\">otvorenog koda</a> i distribuira se pod <a href=\"http://www.gnu.org/copyleft/gpl.html\">GPL</a> licencom.';
$string['welcomep60'] = 'Naredne stranice će Vas provesti kroz nekoliko jednostavnih koraka tokom kojih ćete konfigurisati <strong>Moodle</strong> na Vašem računaru. Možete prihvatiti podrazumevana podešavanja ili ih, opciono, prilagoditi sopstvenim potrebama.';
$string['welcomep70'] = 'Kliknite na dugme za nastavak da biste dalje podešavali <strong>Moodle</strong>.';
$string['wrongdestpath'] = 'Pogrešna odredišna putanja.';
$string['wrongsourcebase'] = 'Pogrešan izvorni URL baze.';
$string['wrongzipfilename'] = 'Pogrešan naziv arhive.';
$string['wwwroot'] = 'Web adresa';
$string['wwwrooterror'] = 'Navedena \'Web adresa\' se čini nevalidnom - ova Moodle instalacija izgleda nije na njoj. Vrednost navedena ispod je resetovana.';
$string['xmlrpcrecommended'] = 'Instaliranje opcionog xmlrpc proširenja je korisno za funkcionalnost Moodle umrežavanje.';
$string['ziprequired'] = 'PHP Ekstenzija Zip sada je obavezna za Moodle, binarne datoteke info-ZIP i biblioteka PclZip više se ne koriste.';
?>
