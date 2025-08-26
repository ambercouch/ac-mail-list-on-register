<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\CodeStyle;

use ACSB\Vendor\JetBrains\PhpStorm\Pure;
use ACSB\Vendor\PhpCsFixer\Fixer\FixerInterface;
use ACSB\Vendor\PhpCsFixer\FixerDefinition\CodeSample;
use ACSB\Vendor\PhpCsFixer\FixerDefinition\FixerDefinition;
use ACSB\Vendor\PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use ACSB\Vendor\PhpCsFixer\Tokenizer\Token;
use ACSB\Vendor\PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
final class BracesOneLineFixer implements FixerInterface
{
    public function isCandidate(Tokens $tokens): bool
    {
        return \true;
    }
    public function isRisky(): bool
    {
        return \false;
    }
    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        /**
         * @var Token $token
         */
        foreach ($tokens as $index => $token) {
            if (!$token->equals('{')) {
                continue;
            }
            $braceStartIndex = $index;
            $braceEndIndex = $tokens->getNextMeaningfulToken($index);
            $token = $tokens[$braceEndIndex];
            if ($token->equals('}')) {
                $beforeBraceIndex = $tokens->getPrevNonWhitespace($braceStartIndex);
                for ($i = $beforeBraceIndex + 1; $i <= $braceEndIndex; $i++) {
                    $tokens->clearAt($i);
                }
                if ($braceEndIndex - $beforeBraceIndex > 2) {
                    $tokens[$beforeBraceIndex + 1] = new Token(' ');
                } else {
                    $tokens->insertAt($beforeBraceIndex + 1, new Token(' '));
                }
                $tokens[$beforeBraceIndex + 2] = new Token('{');
                $tokens[$beforeBraceIndex + 3] = new Token('}');
            }
        }
    }
    public function getName(): string
    {
        return 'PhpStorm/braces_one_line';
    }
    public function getPriority(): int
    {
        return 0;
    }
    public function supports(SplFileInfo $file): bool
    {
        return \true;
    }
    #[Pure]
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition("Braces of empty function's body should be placed on the same line", [new CodeSample(<<<PHP
<?php
declare(strict_types=1);
function foo() {}
PHP
)]);
    }
}
