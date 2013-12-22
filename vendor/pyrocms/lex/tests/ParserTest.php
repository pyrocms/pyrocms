<?php

class ParserTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->parser = new Lex\Parser();
    }

    public function templateDataProvider()
    {
        return array(
            array(
                array(
                    'name' => 'Lex',
                    'filters' => array(
                        'enable' => true,
                    ),
                ),
            ),
        );
    }

    public function testCanSetScopeGlue()
    {
        $this->parser->scopeGlue('~');
        $scopeGlue = new ReflectionProperty($this->parser, 'scopeGlue');

        $this->assertTrue($scopeGlue->isProtected());

        $scopeGlue->setAccessible(true);
        $this->assertEquals('~', $scopeGlue->getValue($this->parser));
    }

    public function testCanGetScopeGlue()
    {
        $this->parser->scopeGlue('~');
        $this->assertEquals('~', $this->parser->scopeGlue());
    }

    public function testValueToLiteral()
    {
        $method = new ReflectionMethod($this->parser, 'valueToLiteral');

        $this->assertTrue($method->isProtected());

        $method->setAccessible(true);

        $this->assertSame("NULL", $method->invoke($this->parser, null));
        $this->assertSame("true", $method->invoke($this->parser, true));
        $this->assertSame("false", $method->invoke($this->parser, false));
        $this->assertSame("'some_string'", $method->invoke($this->parser, "some_string"));
        $this->assertSame("24", $method->invoke($this->parser, 24));
        $this->assertSame("true", $method->invoke($this->parser, array('foo')));
        $this->assertSame("false", $method->invoke($this->parser, array()));

        $mock = $this->getMock('stdClass', array('__toString'));
        $mock->expects($this->any())
             ->method('__toString')
             ->will($this->returnValue('obj_string'));

        $this->assertSame("'obj_string'", $method->invoke($this->parser, $mock));
    }

    /**
     * @dataProvider templateDataProvider
     */
    public function testGetVariable($data)
    {
        $method = new ReflectionMethod($this->parser, 'getVariable');

        $this->assertTrue($method->isProtected());

        $method->setAccessible(true);

        $this->assertEquals('Lex', $method->invoke($this->parser, 'name', $data));
        $this->assertEquals(null, $method->invoke($this->parser, 'age', $data));
        $this->assertEquals(false, $method->invoke($this->parser, 'age', $data, false));

        $this->assertEquals(true, $method->invoke($this->parser, 'filters.enable', $data));
        $this->assertEquals(null, $method->invoke($this->parser, 'filters.name', $data));
        $this->assertEquals(false, $method->invoke($this->parser, 'filters.name', $data, false));

    }

    /**
     * Regression test for https://www.pyrocms.com/forums/topics/view/19686
     */
    public function testFalseyVariableValuesParseProperly()
    {
        $data = array(
            'zero_num' => 0,
            'zero_string' => "0",
            'zero_float' => 0.0,
            'empty_string' => "",
            'null_value' => null,
            'simplexml_empty_node' => simplexml_load_string('<main></main>'),
        );

        $text = "{{zero_num}},{{zero_string}},{{zero_float}},{{empty_string}},{{null_value}},{{simplexml_empty_node}}";
        $expected = '0,0,0,,,';

        $result = $this->parser->parseVariables($text, $data);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider templateDataProvider
     */
    public function testExists($data)
    {
        $result = $this->parser->parse("{{ if exists name }}1{{ else }}0{{ endif }}", $data);
        $this->assertEquals('1', $result);

        $result = $this->parser->parse("{{ if not exists age }}0{{ else }}1{{ endif }}", $data);
        $this->assertEquals('0', $result);
    }

    /**
     * Regression test for https://github.com/fuelphp/lex/issues/2
     *
     * @dataProvider templateDataProvider
     */
    public function testUndefinedInConditional($data)
    {
        $result = $this->parser->parse("{{ if age }}0{{ else }}1{{ endif }}", $data);
        $this->assertEquals('1', $result);
    }

    /**
     * Regression test for https://github.com/pyrocms/pyrocms/issues/1906
     */
    public function testCallbacksInConditionalComparison()
    {
        $result = $this->parser->parse("{{ if foo.bar.baz == 'yes' }}Yes{{ else }}No{{ endif }}", array(), function ($name, $attributes, $content) {
            if ($name == 'foo.bar.baz') {
                return 'yes';
            }
            return 'no';
        });
        $this->assertEquals('Yes', $result);
    }

    /**
     * Test for https://github.com/pyrocms/pyrocms/issues/2104
     *
     * Failing IF statements multiple levels deep
     * - IS_JUL       Tests 'text' == 'text'
     * - TOTAL_GT_0   Tests total > 0
     * - HAS_ENTRIES  Tests isset(entries)
     */
    public function testDeepCallbacksInConditionalComparison()
    {
        $data = array(
            'pagination' => null,
            'total' => 172,
            'years' => array(
                2012 => array(
                    'year' => '2012',
                    'months' => array(
                        '01' => array(
                            'month' => 'jan',
                            'month_num' => '01',
                            'date' => 946713600,
                            'total' => 3,
                            'entries' => array(
                                1326787200 => array(),
                                1326355200 => array(),
                                1325577600 => array(),
                            ),
                        ),
                        '02' => array(
                            'month' => 'feb',
                            'month_num' => '02',
                            'date' => 949392000,
                            'total' => 0,
                        ),
                        '07' => array(
                            'month' => 'jul',
                            'month_num' => '07',
                            'date' => 962434800,
                            'total' => 1,
                            'entries' => array(
                                1343026800 => array(),
                            ),
                        ),
                        10 => array(
                            'month' => 'oct',
                            'month_num' => '10',
                            'date' => 970383600,
                            'total' => 2,
                            'entries' => array(
                                1350543600 => array(),
                                1350457200 => array(),
                            ),
                        ),
                        11 => array(
                            'month' => 'nov',
                            'month_num' => '11',
                            'date' => 973065600,
                            'total' => 4,
                            'entries' => array(
                                1354003200 => array(),
                                1353398400 => array(),
                                1352707200 => array(),
                            ),
                        ),
                        12 => array(
                            'month' => 'dec',
                            'month_num' => '12',
                            'date' => 975657600,
                            'total' => 0,
                        ),
                    ),
                ),
                2011 => array(
                    'year' => '2011',
                    'months' => array(
                        '01' => array(
                            'month' => 'jan',
                            'month_num' => '01',
                            'date' => 946713600,
                            'total' => 0,
                        ),
                        '04' => array(
                            'month' => 'apr',
                            'month_num' => '04',
                            'date' => 954576000,
                            'total' => 13,
                            'entries' => array(
                                1303974000 => array(),
                                1303887600 => array(),
                            ),
                        ),
                        '07' => array(
                            'month' => 'jul',
                            'month_num' => '07',
                            'date' => 962434800,
                            'total' => 0,
                        ),
                        '08' => array(
                            'month' => 'aug',
                            'month_num' => '08',
                            'date' => 965113200,
                            'total' => 8,
                            'entries' => array(
                                1313391600 => array(),
                                1313046000 => array(),
                                1312354800 => array(),
                            ),
                        ),
                    ),
                ),
            ),
        );

        $html = <<<HTML
YEARS(
{{ years }}
    YEAR: {{ year }}
    MONTHS:(
{{ months }}
        MONTH: {{ month }}, IS_JUL: {{ if month == 'jul' }}true{{ else }}false{{ endif }}, TOTAL_GT_0: {{ if total > 0 }}true{{ else }}false{{ endif }}, HAS_ENTRIES: {{ if entries }}true{{ else }}false{{ endif }}

{{ /months }}
    )
{{ /years }}
)
HTML;

        $expected_html = <<<HTML
YEARS(
    YEAR: 2012
    MONTHS:(
        MONTH: jan, IS_JUL: false, TOTAL_GT_0: true, HAS_ENTRIES: true
        MONTH: feb, IS_JUL: false, TOTAL_GT_0: false, HAS_ENTRIES: false
        MONTH: jul, IS_JUL: true, TOTAL_GT_0: true, HAS_ENTRIES: true
        MONTH: oct, IS_JUL: false, TOTAL_GT_0: true, HAS_ENTRIES: true
        MONTH: nov, IS_JUL: false, TOTAL_GT_0: true, HAS_ENTRIES: true
        MONTH: dec, IS_JUL: false, TOTAL_GT_0: false, HAS_ENTRIES: false

    )
    YEAR: 2011
    MONTHS:(
        MONTH: jan, IS_JUL: false, TOTAL_GT_0: false, HAS_ENTRIES: false
        MONTH: apr, IS_JUL: false, TOTAL_GT_0: true, HAS_ENTRIES: true
        MONTH: jul, IS_JUL: true, TOTAL_GT_0: false, HAS_ENTRIES: false
        MONTH: aug, IS_JUL: false, TOTAL_GT_0: true, HAS_ENTRIES: true

    )

)
HTML;

        $result = $this->parser->parse($html, $data);

        $this->assertEquals($expected_html, $result);

    }

    /**
     * Regression test for https://github.com/fuelphp/lex/issues/4
     */
    public function testDoubleTagsBeingGreedy()
    {
        $self = $this;
        $result = $this->parser->parse("{{ foo.bar.baz n='1' }}/{{ foo.bar.baz n='2' }}Content{{ /foo.bar.baz }}", array(), function ($name, $attributes, $content) use ($self) {
            if ($attributes['n'] == 1) {
                $self->assertEquals('', $content);
            } elseif ($attributes['n'] == 2) {
                $self->assertEquals('Content', $content);
            }
        });

    }

}
