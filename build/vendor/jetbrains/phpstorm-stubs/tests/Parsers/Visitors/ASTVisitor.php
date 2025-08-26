<?php

declare (strict_types=1);
namespace ACSB\Vendor\StubTests\Parsers\Visitors;

use ACSB\Vendor\PhpParser\Node;
use ACSB\Vendor\PhpParser\Node\Expr\FuncCall;
use ACSB\Vendor\PhpParser\Node\Stmt\Class_;
use ACSB\Vendor\PhpParser\Node\Stmt\ClassMethod;
use ACSB\Vendor\PhpParser\Node\Stmt\Enum_;
use ACSB\Vendor\PhpParser\Node\Stmt\Function_;
use ACSB\Vendor\PhpParser\Node\Stmt\Interface_;
use ACSB\Vendor\PhpParser\NodeVisitorAbstract;
use ACSB\Vendor\StubTests\Model\CommonUtils;
use ACSB\Vendor\StubTests\Model\PHPClass;
use ACSB\Vendor\StubTests\Model\PHPConstantDeclaration;
use ACSB\Vendor\StubTests\Model\PHPDefineConstant;
use ACSB\Vendor\StubTests\Model\PHPEnum;
use ACSB\Vendor\StubTests\Model\PHPEnumCase;
use ACSB\Vendor\StubTests\Model\PHPFunction;
use ACSB\Vendor\StubTests\Model\PHPInterface;
use ACSB\Vendor\StubTests\Model\PHPMethod;
use ACSB\Vendor\StubTests\Model\PHPProperty;
use ACSB\Vendor\StubTests\Model\StubsContainer;
class ASTVisitor extends NodeVisitorAbstract
{
    public function __construct(protected StubsContainer $stubs, public array &$childEntitiesToAdd, protected bool $isStubCore = \false, public ?string $sourceFilePath = null)
    {
    }
    public function enterNode(Node $node): void
    {
        if ($node instanceof Function_) {
            $function = (new PHPFunction())->readObjectFromStubNode($node);
            $function->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $function->stubBelongsToCore = \true;
            }
            $this->stubs->addFunction($function);
        } elseif ($node instanceof Node\Stmt\EnumCase) {
            $constant = (new PHPEnumCase())->readObjectFromStubNode($node);
            $constant->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $constant->stubBelongsToCore = \true;
            }
            $this->childEntitiesToAdd['enumCases'][] = $constant;
        } elseif ($node instanceof Node\Stmt\ClassConst) {
            $constantDeclaration = (new PHPConstantDeclaration())->readObjectFromStubNode($node);
            foreach ($constantDeclaration->constants as $constant) {
                $constant->sourceFilePath = $this->sourceFilePath;
                if ($this->isStubCore) {
                    $constant->stubBelongsToCore = \true;
                }
                $this->childEntitiesToAdd['classConstants'][] = $constant;
            }
        } elseif ($node instanceof Node\Stmt\Const_) {
            $constantDeclaration = (new PHPConstantDeclaration())->readObjectFromStubNode($node);
            foreach ($constantDeclaration->constants as $constant) {
                $constant->sourceFilePath = $this->sourceFilePath;
                if ($this->isStubCore) {
                    $constant->stubBelongsToCore = \true;
                }
                $this->stubs->addConstant($constant);
            }
        } elseif ($node instanceof FuncCall) {
            if ((string) $node->name === 'define') {
                $constant = (new PHPDefineConstant())->readObjectFromStubNode($node);
                $constant->sourceFilePath = $this->sourceFilePath;
                if ($this->isStubCore) {
                    $constant->stubBelongsToCore = \true;
                }
                $this->stubs->addConstant($constant);
            }
        } elseif ($node instanceof ClassMethod) {
            $method = (new PHPMethod())->readObjectFromStubNode($node);
            $method->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $method->stubBelongsToCore = \true;
            }
            $this->childEntitiesToAdd['methods'][] = $method;
        } elseif ($node instanceof Interface_) {
            $interface = (new PHPInterface())->readObjectFromStubNode($node);
            $interface->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $interface->stubBelongsToCore = \true;
            }
            $this->stubs->addInterface($interface);
        } elseif ($node instanceof Class_) {
            $class = (new PHPClass())->readObjectFromStubNode($node);
            $class->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $class->stubBelongsToCore = \true;
            }
            $this->stubs->addClass($class);
        } elseif ($node instanceof Enum_) {
            $enum = (new PHPEnum())->readObjectFromStubNode($node);
            $enum->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $enum->stubBelongsToCore = \true;
            }
            $this->stubs->addEnum($enum);
        } elseif ($node instanceof Node\Stmt\Property) {
            $property = (new PHPProperty())->readObjectFromStubNode($node);
            $property->sourceFilePath = $this->sourceFilePath;
            if ($this->isStubCore) {
                $property->stubBelongsToCore = \true;
            }
            $this->childEntitiesToAdd['properties'][] = $property;
        }
    }
    public function combineParentInterfaces(PHPInterface $interface): array
    {
        $parents = [];
        if (empty($interface->parentInterfaces)) {
            return $parents;
        }
        /** @var string $parentInterface */
        foreach ($interface->parentInterfaces as $parentInterface) {
            $parents[] = $parentInterface;
            if ($this->stubs->getInterface($parentInterface, $interface->stubBelongsToCore ? null : $interface->sourceFilePath, \false) !== null) {
                foreach ($this->combineParentInterfaces($this->stubs->getInterface($parentInterface, $interface->stubBelongsToCore ? null : $interface->sourceFilePath, \false)) as $value) {
                    $parents[] = $value;
                }
            }
        }
        return $parents;
    }
    public function combineImplementedInterfaces(PHPClass $class): array
    {
        $interfaces = [];
        /** @var string $interface */
        foreach ($class->interfaces as $interface) {
            $interfaces[] = $interface;
            if ($this->stubs->getInterface($interface, $class->stubBelongsToCore ? null : $class->sourceFilePath, \false) !== null) {
                $interfaces[] = $this->stubs->getInterface($interface, $class->stubBelongsToCore ? null : $class->sourceFilePath, \false)->parentInterfaces;
            }
        }
        if ($class->parentClass === null) {
            return $interfaces;
        }
        if ($this->stubs->getClass($class->parentClass, $class->stubBelongsToCore ? null : $class->sourceFilePath, \false) !== null) {
            $inherited = $this->combineImplementedInterfaces($this->stubs->getClass($class->parentClass, $class->stubBelongsToCore ? null : $class->sourceFilePath, \false));
            $interfaces[] = CommonUtils::flattenArray($inherited, \false);
        }
        return $interfaces;
    }
}
