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
}