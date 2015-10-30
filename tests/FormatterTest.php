<?php

namespace Vinelab\Assistant\tests;

use Vinelab\Assistant\Formatter;
use PHPUnit_Framework_TestCase as TestCase;

class FormatterTest extends TestCase
{
    public function setUp()
    {
        mb_internal_encoding('UTF-8');
        $this->ass = new Formatter();
    }

    public function testSnakify()
    {
        $word_with_spaces = 'you can never find chuck norris';
        $this->assertEquals('you_can_never_find_chuck_norris', $this->ass->snakify($word_with_spaces));

        $word_with_uppercase = 'This Sentence is So Fucking Cool';
        $this->assertEquals('this_sentence_is_so_fucking_cool', $this->ass->snakify($word_with_uppercase));

        $word_with_special_character = 'by-word by_dat || bye&bye';
        $this->assertEquals('by-word_by_dat_||_bye&bye', $this->ass->snakify($word_with_special_character));

        $word_with_nothing_really = 'heyyousonofabitch';
        $this->assertEquals('heyyousonofabitch', $this->ass->snakify($word_with_nothing_really));
    }

    public function testCamelify()
    {
        $word_with_spaces = 'you can never find chuck norris';
        $this->assertEquals('youCanNeverFindChuckNorris', $this->ass->camelify($word_with_spaces));

        $word_with_uppercase = 'This Sentence is So Fucking Cool';
        $this->assertEquals('thisSentenceIsSoFuckingCool', $this->ass->camelify($word_with_uppercase));

        $word_with_special_character = 'by-word by_dat || bye&bye';
        $this->assertEquals('by-wordByDat||Bye&bye', $this->ass->camelify($word_with_special_character));

        $word_with_nothing_really = 'heyyousonofabitch';
        $this->assertEquals('heyyousonofabitch', $this->ass->camelify($word_with_nothing_really));
    }

    public function testNeutralize()
    {
        $word_with_spaces = 'you can, never find chuck norris';
        $this->assertEquals('youcanneverfindchucknorris', $this->ass->neutralize($word_with_spaces));

        $word_with_uppercase = 'This Sentence is So Fucking Cool';
        $this->assertEquals('thissentenceissofuckingcool', $this->ass->neutralize($word_with_uppercase));

        $word_with_special_character = 'by-word by_dat || bye&bye';
        $this->assertEquals('bywordbydat||bye&bye', $this->ass->neutralize($word_with_special_character));

        $word_with_nothing_really = 'heyyousonofabitch';
        $this->assertEquals('heyyousonofabitch', $this->ass->neutralize($word_with_nothing_really));
    }

    public function testDashit()
    {
        $word_with_spaces = 'you can never find chuck norris';
        $this->assertEquals('you-can-never-find-chuck-norris', $this->ass->dashit($word_with_spaces));

        $word_with_uppercase = 'This Sentence is So Fucking Cool';
        $this->assertEquals('this-sentence-is-so-fucking-cool', $this->ass->dashit($word_with_uppercase));

        $word_with_special_character = 'by-word by_dat || bye&bye';
        $this->assertEquals('by-word-by_dat-||-bye&bye', $this->ass->dashit($word_with_special_character));

        $word_with_nothing_really = 'heyyousonofabitch';
        $this->assertEquals('heyyousonofabitch', $this->ass->dashit($word_with_nothing_really));

        $utf8word = 'برديس النسور';
        $this->assertEquals('برديس-النسور', $this->ass->dashit($utf8word));
    }

    public function testDate()
    {
        $this->assertEquals(date('d/m/y'), $this->ass->date(''), 'should return current date');
        $db_date_format = '10-02-2010 12:13:00';
        $this->assertEquals('10/02/10', $this->ass->date($db_date_format));
    }

    public function testDateCustomPatter()
    {
        $this->assertEquals(date('d-m-y'), $this->ass->date('', 'd-m-y'), 'should return current date with custom format');
        $db_date_format = '10-02-2010 12:13:00';
        $this->assertEquals(date('d-m-y', strtotime($db_date_format)), $this->ass->date($db_date_format, 'd-m-y'));
    }

    public function testAliasifying()
    {
        $tests = array(
          'simpleTest' => 'simple-test',
          'easy' => 'easy',
          'HTML' => 'html',
          'simple XML' => 'simple-xml',
          'PDFLoad' => 'pdf-load',
          'startMIDDLELast' => 'start-middle-last',
          'AString' => 'a-string',
          'Some4Numbers234' => 'some4-numbers234',
          'TEST123String' => 'test123-string',
          'برديسالنسور' => 'برديسالنسور',
        );

        foreach ($tests as $test => $expected) {
            $this->assertEquals($expected, $this->ass->aliasify($test));
        }
    }

    public function testBr2NewLine()
    {
        $expected = "a\nb\nc\nd \ne";
        $this->ass->br2nl('a<br>b<br>c<br>d <br>e');
    }

    public function testDiv2Br()
    {
        $expected = '<br> hey there<br>hello';
        $this->ass->div2br('<div> hey there<div>hello');
    }

    public function testCleaningHTML()
    {
        $html = '<p>some</p><br><a href="#html">HTML</a><div>cleaned</div><img src="http://come.img" />';
        $clean = "some\n\n<a href=\"#html\">HTML</a>\ncleaned\n";

        $this->assertEquals($clean, $this->ass->cleanHTML($html));
    }
}
