<?php

use PHPUnit\Framework\TestCase;
use Regez\App\RegexGenerator;

class RegexGeneratorTest extends TestCase
{
    public function testSimpleMatch()
    {
        $largeString = "The quick brown fox jumps over the lazy dog.";
        $regex = (new RegexGenerator($largeString))
            ->literal("quick")
            ->whitespace()
            ->literal("brown")
            ->whitespace()
            ->literal("fox");

        $this->assertTrue($regex->match() === 1);
    }

    public function testNoMatch()
    {
        $largeString = "The quick brown fox jumps over the lazy dog.";
        $regex = (new RegexGenerator($largeString))
            ->literal("slow")
            ->whitespace()
            ->literal("green")
            ->whitespace()
            ->literal("turtle");

        $this->assertFalse($regex->match() === 1);
    }

    public function testComplexPattern()
    {
        $largeString = "123-abc-456";
        $regex = (new RegexGenerator($largeString))
            ->digit()->digit()->digit()
            ->literal("-")
            ->wordCharacter()->wordCharacter()->wordCharacter()
            ->literal("-")
            ->digit()->digit()->digit();

        $this->assertTrue($regex->match() === 1);
    }

    public function testMatchAll()
    {
        $largeString = "The quick brown fox jumps over the quick brown dog.";
        $regex = (new RegexGenerator($largeString))
            ->literal("quick")
            ->whitespace()
            ->literal("brown");

        $this->assertEquals(2, $regex->match_all());
    }

    public function testReplace()
    {
        $largeString = "The quick brown fox jumps over the quick brown dog.";
        $regex = (new RegexGenerator($largeString))
            ->literal("quick")
            ->whitespace()
            ->literal("brown");

        $expectedString = "The fast black fox jumps over the fast black dog.";
        $this->assertEquals($expectedString, $regex->replace("fast black"));
    }

    public function testOneOrManyCharactersFrom()
    {
        $largeString = "hello world";
        $regex = (new RegexGenerator($largeString))
            ->oneOrManyCharactersFrom("he");

        $this->assertTrue($regex->match() === 1);
    }

    public function testZeroOrManyCharactersFrom()
    {
        $largeString = "hello";
        $regex = (new RegexGenerator($largeString))
            ->zeroOrManyCharactersFrom("he");

        $this->assertTrue($regex->match() === 1);
    }

    public function testDigit()
    {
        $largeString = "123abc";
        $regex = (new RegexGenerator($largeString))
            ->digit()
            ->digit()
            ->digit();

        $this->assertTrue($regex->match() === 1);
    }

    public function testNonDigit()
    {
        $largeString = "abc";
        $regex = (new RegexGenerator($largeString))
            ->nonDigit()
            ->nonDigit()
            ->nonDigit();

        $this->assertTrue($regex->match() === 1);
    }

    public function testWordCharacter()
    {
        $largeString = "word";
        $regex = (new RegexGenerator($largeString))
            ->wordCharacter()
            ->wordCharacter()
            ->wordCharacter()
            ->wordCharacter();

        $this->assertTrue($regex->match() === 1);
    }

    public function testNonWordCharacter()
    {
        $largeString = "!@#";
        $regex = (new RegexGenerator($largeString))
            ->nonWordCharacter()
            ->nonWordCharacter()
            ->nonWordCharacter();

        $this->assertTrue($regex->match() === 1);
    }

    public function testWhitespace()
    {
        $largeString = " ";
        $regex = (new RegexGenerator($largeString))
            ->whitespace();

        $this->assertTrue($regex->match() === 1);
    }

    public function testNonWhitespace()
    {
        $largeString = "a";
        $regex = (new RegexGenerator($largeString))
            ->nonWhitespace();

        $this->assertTrue($regex->match() === 1);
    }

    public function testStartOfString()
    {
        $largeString = "hello world";
        $regex = (new RegexGenerator($largeString))
            ->startOfString()
            ->literal("hello");

        $this->assertTrue($regex->match() === 1);
    }

    public function testEndOfString()
    {
        $largeString = "hello world";
        $regex = (new RegexGenerator($largeString))
            ->literal("world")
            ->endOfString();

        $this->assertTrue($regex->match() === 1);
    }

    public function testAnyCharacter()
    {
        $largeString = "a";
        $regex = (new RegexGenerator($largeString))
            ->anyCharacter();

        $this->assertTrue($regex->match() === 1);
    }

    public function testZeroOrMore()
    {
        $largeString = "aaa";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->zeroOrMore();

        $this->assertTrue($regex->match() === 1);
    }

    public function testOneOrMore()
    {
        $largeString = "aaa";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->oneOrMore();

        $this->assertTrue($regex->match() === 1);
    }

    public function testZeroOrOne()
    {
        $largeString = "a";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->zeroOrOne();

        $this->assertTrue($regex->match() === 1);
    }

    public function testExactly()
    {
        $largeString = "aaa";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->exactly(3);

        $this->assertTrue($regex->match() === 1);
    }

    public function testAtLeast()
    {
        $largeString = "aaa";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->atLeast(2);

        $this->assertTrue($regex->match() === 1);
    }

    public function testBetween()
    {
        $largeString = "aaaa";
        $regex = (new RegexGenerator($largeString))
            ->literal("a")
            ->between(2, 3);

        $this->assertTrue($regex->match() === 1);
    }

    public function testGroup()
    {
        $largeString = "abc";
        $regex = (new RegexGenerator($largeString))
            ->group("ab")
            ->literal("c");

        $this->assertTrue($regex->match() === 1);
    }

    public function testOr()
    {
        $largeString = "abc";
        $regex = (new RegexGenerator($largeString))
            ->group("a|b")
            ->literal("c");

        $this->assertTrue($regex->match() === 1);
    }
}