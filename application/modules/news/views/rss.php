<?php 
echo '<?xml version="1.0" encoding="utf-8"?>' . "
";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title><?=$rss->feed_name; ?></title>
		<link><?=$rss->feed_url; ?></link>
		<description><?=$rss->page_description; ?></description>
		<dc:language><?=$rss->page_language; ?></dc:language>
		<dc:creator><?=$rss->creator_email; ?></dc:creator>
		<dc:rights>Copyright <?=gmdate("Y", time()); ?></dc:rights>
		<admin:generatorAgent rdf:resource="http://www.styledna.net/" />
		
		<? foreach($rss->items as $item): ?>
			<item>
				<title><?=$item->title;?></title>
				<link><?=$item->link;?></link>
				<description><![CDATA[<?=$item->description;?>]]></description>
				<? //'<author>< ? = lang('news_author_name_label'); ? ></author>'; ?>
				<pubDate><?=$item->date;?></pubDate>
				<guid><?=$item->guid;?></guid>
			</item>
		<? endforeach; ?>
	</channel>
</rss>