<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Oversikt</6><hr>
<p>Fil-modulen er en fin m�te � h�ndtere filer som brukes p� denne websiden.
Alle bilder eller filer som legges til p� sider, gallerier eller blogginnlegg vises her. 
For bilder kan du laste dem direkte opp via WYSIWYG editoren  eller du kan laste dem opp her og legge dem til via WYSIWYG editoren.</p>
<p>Oversikten her virker ganske mye som ditt lokale filsystem: Det brukes h�yreklikk for � vise en meny. Og alt i midten er klikkbart.</p>

<h6>H�ndteirng av mapper</h6>
<p>Du kan lage s� mange undermappe som du bare �nsker som for eksempel: \"blogg/bilder/skjermdumper\" eller \"sider/lyd\".
Mappenavene vil bli skjult og vises kun her for � holde en struktur p� hvor ting eksiterer. For � redigere en mappe kan du enten h�yreklikke og velge en handling eller dobbelklikke for � �pne den.
Du kan ogs� klikke p� mapper i benstr kolonne for � �pne dem.</p>
<p>Hvis sky-tjenester er aktiivert kan du angi plasseringen av mappen ved � h�yreklikke p� en mappe og velge Detaljer. Du kan da velge en plassering (for eksempel \"Amazon S3\") og legge til navnet for din sky-tjenste.
Hvis mappen ikke ekisterer vil den bli opprettet. Merk at du kan kun endre plassering hvis mappen er tom.</p>

<h6>H�ndtering av filer</h6>
<p>For � behandle filer navigere til mappen ved � bruke mappestrukturen i venstre kolonne eller ved � klikke p� mappen i den midterste ruten.
N�r du finner den filen du vil redigere kan du h�yreklikke for � utf�re handlinger. Du kan ogs� flytte p� dem ved � dra dem p� plass, enten opp eller ned. Merk
at hvis du har mapper og filer i den samme overordnede mappen s� vil mappene vises alltid f�rst, etterfulgt av filene.</p>

<h6>Opplasting av filer</h6>
<p>Etter � h�yreklikket p� en mappe vil opplastningsvinduet vises.
Du kan legge til filer ved �enten slippe dem i \"Last opp Filer\" boksen eller ved � klikke i boksen og velge filene.
Du kan velge flere filer ved � holde Kontroll / Kommando eller Shift-tasten mens du klikker dem. De valgte filene vil vises i en liste nederst p� skjermen.
Du kan da enten slette un�dvendige filer fra listen, eller starte � laste dem opp </p>
<p>Hvis du f�r en advarsel om at filst�rrelsen er for stor s� kan det hende at din vert ikke tillater filopplasting st�rre en 2MB.
For � kunne komme unna dette kan du enten sp�rre din vert om � f� �ke grensen eller hvis du pr�ver � last opp �t bilde kan du pr�ve � endre st�rrelsen p� det f�r opplasting.
Du kan endre opplastingen grensen i Kontrollpanel > Filer > Innstillinger ogs�, men det er sekund�rt til vertens begrensning. For eksempel hvis verten tillater en 50MB opplasting du kan fortsatt begrense st�rrelsen
av opplastingen ved � angi maksimum \ "20 \" (for eksempel) i Kontrollpanel > Filer > Innstillinger.</p>

<h6>Synkronisere filer</h6>
<p>Hvis du lagrer filer med en sky-tjenste kan v�re lurt � bruke Synkroniser-funksjonen. Dette tillater deg � \"oppdatere\"
databasen av filer for � holde den oppdatert med den eksterne lagringssted. For eksempel hvis du har en annen tjeneste
som laster opp filer i en mappe p� Amazon som du vil vise i dine ukentlige blogginnlegg  g� til mappen din
som er knyttet til at tjensten og deretter Synkroniser. Dette vil trekke ned all tilgjengelig informasjon fra Amazon og
lagre det i databasen som om filen ble lastet opp via Filer-grensesnittet. Filene er n� tilgjengelig til � settes inn sidens innhold,
blogginnlegget, eller galleriet. Hvis filene har blitt slettet fra den eksterne tjenesten siden sist synkronisering vil de bli fjernet her ogs�.</p>

<h6>S�k</h6>
<p>Du kan s�ke i alle filer og mapper ved � skrive et s�keord i h�yre kolonne og deretter trykke Enter. De f�rste 5 mappene og filene som passer til navnet vil bli vist.
N�r du klikker p� et element vil mappene/filene der elementet er plasser bli vist og det du s�kte etter vil bli markert. 
Elementer er s�kt etter ved � bruke mappenavn, filenavn, filendelse, plassering og eksternt mappenavn.</p>";