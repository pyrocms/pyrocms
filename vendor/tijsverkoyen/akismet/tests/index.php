<?php

//require
require_once '../../../autoload.php';
require_once 'config.php';

use \TijsVerkoyen\Akismet\Akismet;

// create instance
$akismet = new Akismet(APIKEY, URL);

$response = $akismet->verifyKey();
//$response = $akismet->isSpam('Nice one. Thanks', 'Joris', 'joris@verkoyen.eu', '', null, 'comment');
//$response = $akismet->submitHam(
//	'Great portal! <a href="http://key-west-florida-fishing-charters.6xyotd.us/ " rel="nofollow">Key west florida fishing charters</a><a href="http://kates-playground-videos.6xyotd.us/ " rel="nofollow">Kates playground videos</a><a href="http://karaoke-norah-jones.6xyotd.us/ " rel="nofollow">Karaoke norah jones</a><a href="http://kiera-knightly-naked.6xyotd.us/ " rel="nofollow">Kiera knightly naked</a><a href="http://kelli-fox.6xyotd.us/ " rel="nofollow">Kelli fox</a><a href="http://ky-farm-bureau.6xyotd.us/ " rel="nofollow">Ky farm bureau</a><a href="http://kari-gold.6xyotd.us/ " rel="nofollow">Kari gold</a><a href="http://julie-gibson-diaspora.6xyotd.us/ " rel="nofollow">Julie gibson diaspora</a><a href="http://keely-net.6xyotd.us/ " rel="nofollow">Keely net</a><a href="http://kellie-pickler-tits.6xyotd.us/ " rel="nofollow">Kellie pickler tits</a><a href="http://korean-central-news-agency.6xyotd.us/ " rel="nofollow">Korean central news agency</a><a href="http://kings-quest-3-walkthru.6xyotd.us/ " rel="nofollow">King&#8217;s quest 3 walkthru</a><a href="http://kennels-in-hilton-head.6xyotd.us/ " rel="nofollow">Kennels in hilton head</a><a href="http://kentucky-tv-stations.6xyotd.us/ " rel="nofollow">Kentucky tv stations</a><a href="http://kauffman-foundation.6xyotd.us/ " rel="nofollow">Kauffman foundation</a><a href="http://jungle-diaper-cakes.6xyotd.us/ " rel="nofollow">Jungle diaper cakes</a><a href="http://kimba-the-white-lion.6xyotd.us/ " rel="nofollow">Kimba the white lion</a><a href="http://julie-harris.6xyotd.us/ " rel="nofollow">Julie harris</a><a href="http://kona-hi.6xyotd.us/ " rel="nofollow">Kona hi</a><a href="http://kids-cowboy-boots.6xyotd.us/ " rel="nofollow">Kids cowboy boots</a><a href="http://kimora-simmons.6xyotd.us/ " rel="nofollow">Kimora simmons</a><a href="http://kermit-the-frog.6xyotd.us/ " rel="nofollow">Kermit the frog</a><a href="http://justin-nozuka.6xyotd.us/ " rel="nofollow">Justin nozuka</a><a href="http://katie-james-actress.6xyotd.us/ " rel="nofollow">Katie james actress</a><a href="http://king-neptune.6xyotd.us/ " rel="nofollow">King neptune</a> yefvo',
//	'ofqqn',
//	'hxoac@mail.com'
//);

//output
ob_start();
var_dump($response);
