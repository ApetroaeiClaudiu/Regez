<?php

namespace Regez\App;

class RegexGenerator
{
    private string $subject;
    private string $pattern;

    public function __construct(string $subject)
    {
        $this->subject = $subject;
        $this->pattern = "/";
    }

    public function match(): int|bool
    {
        $this->pattern .= "/";

        return preg_match($this->pattern, $this->subject);
    }    

    public function match_all(): int|bool
    {
        $this->pattern .= "/";

        return preg_match_all($this->pattern, $this->subject);
    }

    public function replace(string $to_replace): ?string
    {
        $this->pattern .= "/";

        return preg_replace($this->pattern, $to_replace, $this->subject);
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function oneOrManyCharactersFrom(string $characters): self
    {
        $this->pattern .= "[" . preg_quote($characters, '/') . "]+";

        return $this;
    }

    public function zeroOrManyCharactersFrom(string $characters): self
    {
        $this->pattern .= "[" . preg_quote($characters, '/') . "]*";

        return $this;
    }

    public function digit(): self
    {
        $this->pattern .= "\\d";

        return $this;
    }

    public function nonDigit(): self
    {
        $this->pattern .= "\\D";

        return $this;
    }

    public function wordCharacter(): self
    {
        $this->pattern .= "\\w";

        return $this;
    }

    public function nonWordCharacter(): self
    {
        $this->pattern .= "\\W";

        return $this;
    }

    public function whitespace(): self
    {
        $this->pattern .= "\\s";

        return $this;
    }

    public function nonWhitespace(): self
    {
        $this->pattern .= "\\S";

        return $this;
    }

    public function startOfString(): self
    {
        $this->pattern .= "^";

        return $this;
    }

    public function endOfString(): self
    {
        $this->pattern .= "$";

        return $this;
    }

    public function literal(string $literal): self
    {
        $this->pattern .= preg_quote($literal, '/');

        return $this;
    }

    public function anyCharacter(): self
    {
        $this->pattern .= ".";

        return $this;
    }

    public function zeroOrMore(): self
    {
        $this->pattern .= "*";

        return $this;
    }

    public function oneOrMore(): self
    {
        $this->pattern .= "+";

        return $this;
    }

    public function zeroOrOne(): self
    {
        $this->pattern .= "?";

        return $this;
    }

    public function exactly(int $n): self
    {
        $this->pattern .= "{" . $n . "}";

        return $this;
    }

    public function atLeast(int $n): self
    {
        $this->pattern .= "{" . $n . ",}";

        return $this;
    }

    public function between(int $min, int $max): self
    {
        $this->pattern .= "{" . $min . "," . $max . "}";

        return $this;
    }

    public function group(string $pattern): self
    {
        $this->pattern .= "(" . $pattern . ")";

        return $this;
    }

    public function or(string $pattern): self
    {
        $this->pattern .= "|" . $pattern;

        return $this;
    }
}