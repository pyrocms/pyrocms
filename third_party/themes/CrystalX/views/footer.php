	<div id="top" class="noprint"><p><span class="noscreen">Back on top</span> <a href="#header" title="Back on top ^">^<span></span></a></div>
	<hr class="noscreen" />
	
	<p id="createdby">created by <a href="http://www.nuvio.cz">Nuvio | Webdesign</a> <!-- DON�T REMOVE, PLEASE! --></p>
	<p id="copyright">
	{if navigation('footer')}
	|
	{foreach navigation('footer') link}
		<span class="link">{anchor($link->url, $link->title, array(target=$link->target))} | </span>
	{/foreach}</p>