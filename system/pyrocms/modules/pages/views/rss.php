<?php echo '<?xml version="1.0" encoding="'. $this->config->item('charset') .'"?>'; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title><?php echo $rss->title; ?></title>
		<link><?php echo $rss->link; ?></link>
		<description><![CDATA[<?php echo $rss->description; ?>]]></description>
		<dc:language><?php echo CURRENT_LANGUAGE; ?></dc:language>
		<dc:creator><?php echo $rss->creator_email; ?></dc:creator>
		<admin:generatorAgent rdf:resource="http://pyrocms.com/" />
		
		<?php foreach($rss->items as $item): ?>
			<item>
				<title><?php echo $item->title;?></title>
				<link><?php echo $item->link;?></link>
				<description><![CDATA[<?php echo $item->description;?>]]></description>
				<?php //'<author>< ? = lang('blog_author_name_label'); ? ></author>'; ?>
				<pubDate><?php echo $item->date;?></pubDate>
				<guid><?php echo $item->guid;?></guid>
			</item>
		<?php endforeach; ?>
	</channel>
</rss>