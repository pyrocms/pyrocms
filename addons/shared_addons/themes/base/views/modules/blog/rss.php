<?php
echo '<?xml version="1.0" encoding="utf-8"?>' . "
";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title><?php echo $rss->feed_name; ?></title>
		<link><?php echo $rss->feed_url; ?></link>
		<description><?php echo $rss->page_description; ?></description>
		<dc:language><?php echo $rss->page_language; ?></dc:language>
		<dc:creator><?php echo $rss->creator_email; ?></dc:creator>
		<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
		<admin:generatorAgent rdf:resource="http://www.styledna.net/" />

		<?php if ( ! empty($rss->items)): ?>
		<?php foreach($rss->items as $item): ?>
			<item>
				<title><?php echo $item->title;?></title>
				<link><?php echo $item->link;?></link>
				<description><![CDATA[<?php echo $item->description;?>]]></description>
				<?php //'<author>< ? = lang('blog:author_name_label'); ? ></author>'; ?>
				<pubDate><?php echo $item->date;?></pubDate>
				<guid><?php echo $item->guid;?></guid>
			</item>
		<?php endforeach; ?>
		<?php endif; ?>
	</channel>
</rss>