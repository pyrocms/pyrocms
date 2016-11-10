<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Oversikt</6><hr>
<p>Fil-modulen er en fin måte å håndtere filer som brukes på denne websiden.
Alle bilder eller filer som legges til på sider, gallerier eller blogginnlegg vises her. 
For bilder kan du laste dem direkte opp via WYSIWYG editoren  eller du kan laste dem opp her og legge dem til via WYSIWYG editoren.</p>
<p>Oversikten her virker ganske mye som ditt lokale filsystem: Det brukes høyreklikk for å vise en meny. Og alt i midten er klikkbart.</p>

<h6>Håndteirng av mapper</h6>
<p>Du kan lage så mange undermappe som du bare ønsker som for eksempel: \"blogg/bilder/skjermdumper\" eller \"sider/lyd\".
Mappenavene vil bli skjult og vises kun her for å holde en struktur på hvor ting eksiterer. For å redigere en mappe kan du enten høyreklikke og velge en handling eller dobbelklikke for å åpne den.
Du kan også klikke på mapper i benstr kolonne for å åpne dem.</p>
<p>Hvis sky-tjenester er aktiivert kan du angi plasseringen av mappen ved å høyreklikke på en mappe og velge Detaljer. Du kan da velge en plassering (for eksempel \"Amazon S3\") og legge til navnet for din sky-tjenste.
Hvis mappen ikke ekisterer vil den bli opprettet. Merk at du kan kun endre plassering hvis mappen er tom.</p>

<h6>Håndtering av filer</h6>
<p>For å behandle filer navigere til mappen ved å bruke mappestrukturen i venstre kolonne eller ved å klikke på mappen i den midterste ruten.
Når du finner den filen du vil redigere kan du høyreklikke for å utføre handlinger. Du kan også flytte på dem ved å dra dem på plass, enten opp eller ned. Merk
at hvis du har mapper og filer i den samme overordnede mappen så vil mappene vises alltid først, etterfulgt av filene.</p>

<h6>Opplasting av filer</h6>
<p>Etter å høyreklikket på en mappe vil opplastningsvinduet vises.
Du kan legge til filer ved åenten slippe dem i \"Last opp Filer\" boksen eller ved å klikke i boksen og velge filene.
Du kan velge flere filer ved å holde Kontroll / Kommando eller Shift-tasten mens du klikker dem. De valgte filene vil vises i en liste nederst på skjermen.
Du kan da enten slette unødvendige filer fra listen, eller starte å laste dem opp </p>
<p>Hvis du får en advarsel om at filstørrelsen er for stor så kan det hende at din vert ikke tillater filopplasting større en 2MB.
For å kunne komme unna dette kan du enten spørre din vert om å få øke grensen eller hvis du prøver å last opp ét bilde kan du prøve å endre størrelsen på det før opplasting.
Du kan endre opplastingen grensen i Kontrollpanel > Filer > Innstillinger også, men det er sekundært til vertens begrensning. For eksempel hvis verten tillater en 50MB opplasting du kan fortsatt begrense størrelsen
av opplastingen ved å angi maksimum \ "20 \" (for eksempel) i Kontrollpanel > Filer > Innstillinger.</p>

<h6>Synkronisere filer</h6>
<p>Hvis du lagrer filer med en sky-tjenste kan være lurt å bruke Synkroniser-funksjonen. Dette tillater deg å \"oppdatere\"
databasen av filer for å holde den oppdatert med den eksterne lagringssted. For eksempel hvis du har en annen tjeneste
som laster opp filer i en mappe på Amazon som du vil vise i dine ukentlige blogginnlegg  gå til mappen din
som er knyttet til at tjensten og deretter Synkroniser. Dette vil trekke ned all tilgjengelig informasjon fra Amazon og
lagre det i databasen som om filen ble lastet opp via Filer-grensesnittet. Filene er nå tilgjengelig til å settes inn sidens innhold,
blogginnlegget, eller galleriet. Hvis filene har blitt slettet fra den eksterne tjenesten siden sist synkronisering vil de bli fjernet her også.</p>

<h6>Søk</h6>
<p>Du kan søke i alle filer og mapper ved å skrive et søkeord i høyre kolonne og deretter trykke Enter. De første 5 mappene og filene som passer til navnet vil bli vist.
Når du klikker på et element vil mappene/filene der elementet er plasser bli vist og det du søkte etter vil bli markert. 
Elementer er søkt etter ved å bruke mappenavn, filenavn, filendelse, plassering og eksternt mappenavn.</p>";