<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\Parsers\Visitors;

use ACSB\Vendor\StubTests\Model\StubsContainer;
class CoreStubASTVisitor extends ASTVisitor
{
    public function __construct(StubsContainer $stubs, array &$entitiesToUpdate)
    {
        parent::__construct($stubs, $entitiesToUpdate);
        $this->isStubCore = \true;
    }
}
