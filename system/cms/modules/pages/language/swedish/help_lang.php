<?php defined('BASEPATH') or exit('No direct script access allowed');

 /**
 * Swedish translation.
 *
 * @author		marcus@incore.se
 * @package		PyroCMS
 * @link		http://pyrocms.com
 * @date		2012-10-22
 * @version		1.1.0
 */

$lang['help_body'] = '<h4> Översikt </ h4>
<p>Sidmodulen är ett enkelt men kraftfullt sätt att hantera statiskt innehåll på din webbplats.
Sidlayouter kan hanteras och widgets kan bäddas in utan att du behöver redigera mallfilerna. </ P>

<h4> Hantera sidor </ h4> <hr>
<h6> Sidinnehåll </ h6>
<p> När du väljer din sidas titel, kom ihåg att i standardsidlayouten visas sidans titel ovanför sidans innehåll.
Skapa nu din sida med hjälp av den WYSIWYG redigeraren.
När du är redo för att göra sidan synlig för besökarna så anger du att den ska vara publik och och sidan kommer att vara synlig.
<strong> Du måste också gå till Design -.> Navigation och skapa en ny navigeringslänk om du vill att din sida ska dyka upp i menyn </ strong> </ p>

<h6> Metadata </ ​​h6>
<p> Metatitel visas i allmänhet som titeln i sökresultaten och tros väga tungt i sidrankning. /> <br
Metasökord är ord som beskriver din webbplats innehåll och är till nytta för sökmotorer bara. <br />
Den metabeskrivning är en kort beskrivning av denna sida som indexeras av sökmotorer. </ P>

<h6> Design </ h6>
<p>Fliken Design kan du välja en anpassad sidlayout och eventuellt tillämpa sidunika CSS-format.
Se Sidlayout nedan för instruktioner om hur man bäst använder sidlayouter. </ P>

<h6> Skript </ h6>
<p> Du kan placera javaskript här som du vill ska infogas i &lt;head&gt;-taggen på sidan. </ p>

<h6> Alternativ </ h6>
<p> Låter dig aktivera kommentarer och ett RSS-flöde för denna sida.
Om RSS-flödet är aktiverat kan en besökare prenumerera på den här sidan och de kommer att få varje undersida i sin RSS-läsare. </ P>

<h6> Revideringar </ h6>
<p> Revideringar är en mycket kraftfull och användbar funktion för att redigera en befintlig sida.
Om någon råkar förstöra en sida i textredigeraren så välj bara ett datum som du vill återställa sidan till och klicka på Spara!
Du kan även jämföra versioner för att se vad som förändrats. </ P>

<h4>Sidlayouter </ h4> <hr>
<p> Med sidlayouter kan du styra layouten på sidan utan att ändra temafilerna.
Du kan bädda in taggar i sidlayouten istället för att placera dem i varje sida.
Till exempel: Om du har en "Twitter feed widget" som du vill visa längst ned på varje sida kan du bara placera widget-taggen i sidlayouten:
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
Nu kan du applicera en CSS-stil till \ "my-twitter-widget \" klassen i CSS-fliken. </ P>';