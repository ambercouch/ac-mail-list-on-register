<?php

declare (strict_types=1);
namespace ACSB\Vendor\PhpParser\Node\Expr;

use ACSB\Vendor\PhpParser\Node;
use ACSB\Vendor\PhpParser\Node\Expr;
use ACSB\Vendor\PhpParser\Node\Name;
use ACSB\Vendor\PhpParser\Node\VarLikeIdentifier;
class StaticPropertyFetch extends Expr
{
    /** @var Name|Expr Class name */
    public Node $class;
    /** @var VarLikeIdentifier|Expr Property name */
    public Node $name;
    /**
     * Constructs a static property fetch node.
     *
     * @param Name|Expr $class Class name
     * @param string|VarLikeIdentifier|Expr $name Property name
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(Node $class, $name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->class = $class;
        $this->name = \is_string($name) ? new VarLikeIdentifier($name) : $name;
    }
    public function getSubNodeNames(): array
    {
        return ['class', 'name'];
    }
    public function getType(): string
    {
        return 'Expr_StaticPropertyFetch';
    }
}
