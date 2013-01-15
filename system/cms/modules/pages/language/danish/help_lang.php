<?php defined('BASEPATH') or exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Overblik</h4>
<p>Sidemodulet er en simpel, men effektiv måde at håndtere statisk indhold på din side.
Side types administreres og widgets indsættes uden nogensinde at redigere skabelonfilerne.</p>

<h4>Sidehåndtering</h4><hr>
<h6>Side Indhold</h6>
<p>Når du vælger en sidetitel, så husk at standardsidelayoutet vil vise sidetitlen over sideindholdet.
Opret nu sideindholde på din side med WYSIWYG editoren. Når du er klar til at siden skal vises for besøgende,
kan du sætte sidestatus til Live, og den vil være tilgængelig på den viste URL.
<strong>Du skal også gå til Design -> Navigation og oprette et nyt navigationslink hvis du vil have at siden skal vises i menuen.</strong></p>

<h6>Meta data</h6>
<p>Meta titel bruges generelt som titlen i søgeresultater, og har stor betydning for page rank.<br />
Meta nøgleord er ord der beskriver din sides indhold og som udelukkende har gavn for søgemaskiner. </br>
Meta beskrivelsen er en kort beskrivelse af denne side, og kan bruges som søgesnippet hvis søgemaskinerne  vurderer det relevant for søgningen.</p>

<h6>Design</h6>
<p>Design fanebladet lader dig vælge et customiseret sidelayout og tilføjelse af forskellige css styles til den på den side alene.
Kig i Side types sektionen nedenunder for instruktioner omkring hvordan Side types bruges bedst.</p>

<h6>Script</h6>
<p>Her kan du placere javascript som du vil tilføje til < head > sektionen på siden.</p>

<h6>Indstillinger</h6>
<p>Lader dig slå kommentarer og et rss feed for siden til og fra.
Hvis RSS feeded er slået til kan en besøgende abbonnere på denne side, og de vil modtage hver undersige i deres rss læser.</p>

<h6>Revisioner</h6>
<p>Revisioner er et meget kraftfuldt og handy feature til at redigere eksisterende sider.
Hvis en ny ansat virkelig ødelægger noget ved en redigering skal du bare vælge en dato og gå tilbage til den dato og vælge Gem!
Du kan endda sammenligne revisioner for at se hvad der er ændret.</p>

<h4>Side Types</h4><hr>
<p>Side types lader dig kontrollere layoutet på siden uden at modificere temafilerne.
Du kan indsætte tags i sidelayoutet istedet for at palcere dem på hver side.
F.eks.: Hvis du vil have en twitter feed widget vist i bunden af hver side kan du indsætte widget tagget i side layoutet sådan:
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
Nu kan du tilføje css styling til \"min-twitter-widget\" klassen i CSS fanebladet</p>";