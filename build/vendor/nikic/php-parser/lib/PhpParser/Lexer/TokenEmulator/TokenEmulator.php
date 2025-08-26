<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\Lexer\TokenEmulator;

use ACSB\Vendor\PhpParser\PhpVersion;
use ACSB\Vendor\PhpParser\Token;
/** @internal */
abstract class TokenEmulator
{
    abstract public function getPhpVersion(): PhpVersion;
    abstract public function isEmulationNeeded(string $code): bool;
    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    abstract public function emulate(string $code, array $tokens): array;
    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    abstract public function reverseEmulate(string $code, array $tokens): array;
    /** @param array{int, string, string}[] $patches */
    public function preprocessCode(string $code, array &$patches): string
    {
        return $code;
    }
}
