<?php

/**
 * Lexicon config
 */
return array(

    /**
     * The extension that tells the view environment when to use the Lexicon view engine to process views.
     */
    'extension' => 'html',

    /**
     * The default scope glue that is used for parsing and getting variables with dot notation or a different character
     * if set here. We highly recommend that you leave the default `.`.
     */
    'scopeGlue' => '.',

    /**
     * When debug is turned on it enables exceptions on certain parts where things fail silently. Generic exceptions
     * will always be logged.
     */
    'debug' => true,

    /**
     * PHP is escaped from views by default but you can enable it if you need it for any reason. It is highly
     * recommended that you keep this disabled as it will make templates insecure.
     */
    'allowPhp' => false,

    /**
     * Plugins used for interpreting and outputting custom data. You can add you custom plugins here. Each one must have
     * a key that will represent the tag. i.e {{ counter.count }}
     */
    'plugins' => [
        'counter' => 'Anomaly\Lexicon\Plugin\CounterPlugin',
        'foo'     => 'Anomaly\Lexicon\Plugin\FooPlugin',
        'test'    => 'Anomaly\Lexicon\Plugin\TestPlugin',
    ],

    /**
     * Conditional boolean test types
     */
    'booleanTestTypes' => [
        'stringTest' => 'Anomaly\Lexicon\Conditional\Test\StringTest',
        'traversableTest' => 'Anomaly\Lexicon\Conditional\Test\TraversableTest',
    ],


    /**
     * Conditional handler class
     */
    'conditionalHandler' => 'Anomaly\Lexicon\Conditional\ConditionalHandler',

    /**
     * Plugin handler class
     */
    'pluginHandler' => 'Anomaly\Lexicon\Plugin\PluginHandler',

    /**
     * Node types used for parsing and compiling.
     * The order is very important as it will affect parsing.
     */
    'nodeTypes' => [
        'Anomaly\Lexicon\Node\Comment',
        'Anomaly\Lexicon\Node\IgnoreBlock',
        'Anomaly\Lexicon\Node\IgnoreVariable',
        'Anomaly\Lexicon\Node\Block',
        'Anomaly\Lexicon\Node\Recursive',
        'Anomaly\Lexicon\Node\Section',
        'Anomaly\Lexicon\Node\SectionAppend',
        'Anomaly\Lexicon\Node\SectionExtends',
        'Anomaly\Lexicon\Node\SectionOverwrite',
        'Anomaly\Lexicon\Node\SectionShow',
        'Anomaly\Lexicon\Node\SectionStop',
        'Anomaly\Lexicon\Node\SectionYield',
        'Anomaly\Lexicon\Node\Includes',
        'Anomaly\Lexicon\Node\Conditional',
        'Anomaly\Lexicon\Node\ConditionalElse',
        'Anomaly\Lexicon\Node\ConditionalEndif',
        'Anomaly\Lexicon\Node\VariableEscaped',
        'Anomaly\Lexicon\Node\Variable',
    ],

);