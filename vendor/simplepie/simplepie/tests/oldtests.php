<?php

date_default_timezone_set('UTC');
error_reporting(E_ALL | E_STRICT);

require_once dirname(__FILE__) . '/bootstrap.php';
require_once dirname(__FILE__) . '/oldtests/compat_test_harness.php';
require_once dirname(__FILE__) . '/oldtests/functions.php';

class OldTest extends PHPUnit_Framework_TestCase
{
    public function getTests()
    {
        $test_folders = array(
            'absolutize',
            'date',
            'feed_category_label',
            'feed_copyright',
            'feed_description',
            'feed_image_height',
            'feed_image_link',
            'feed_image_title',
            'feed_image_url',
            'feed_image_width',
            'feed_language',
            'feed_link',
            'feed_title',
            'first_item_author_name',
            'first_item_category_label',
            'first_item_content',
            'first_item_contributor_name',
            'first_item_date',
            'first_item_description',
            'first_item_id',
            'first_item_latitude',
            'first_item_longitude',
            'first_item_permalink',
            'first_item_title',
            'itunes_rss'
        );
        
        $master = new Unit_Test2_Group('SimplePie Test Suite');
        
        foreach ($test_folders as $test)
        {
            $test_group = new SimplePie_Unit_Test2_Group(ucwords(str_replace('_', ' ', $test)));
            $test_group->load_folder(dirname(__FILE__) . '/oldtests/' . $test);
            $master->add($test_group);
        }
        
        $test_group = new SimplePie_Unit_Test2_Group('Who knows a <title> from a hole in the ground?');
        $test_group->load_folder(dirname(__FILE__) . '/oldtests/who_knows_a_title_from_a_hole_in_the_ground');
        $master->add($test_group);
        
        $tests = array();
        $groups = array($master);
        while ($group = array_shift($groups))
        {
            foreach ($group->tests as $group_tests)
            {
                foreach ($group_tests as $test)
                {
                    if ($test instanceof Unit_Test2)
                    {
                        $tests[] = array($test);
                    }
                    elseif ($test instanceof Unit_Test2_Group)
                    {
                        $groups[] = $test;
                    }
                }
            }
        }
        return $tests;
    }
 
    /**
     * @dataProvider getTests
     */
    public function testOld($test)
    {
        $test->run();
        $this->assertSame($test->expected, $test->result);
    }
}
