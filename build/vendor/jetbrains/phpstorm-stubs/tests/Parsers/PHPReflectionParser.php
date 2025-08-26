<?php

namespace ACSB\Vendor\StubTests\Parsers;

use ReflectionClass;
use ReflectionEnum;
use ReflectionFunction;
use ACSB\Vendor\StubTests\Model\CommonUtils;
use ACSB\Vendor\StubTests\Model\PHPClass;
use ACSB\Vendor\StubTests\Model\PHPConstant;
use ACSB\Vendor\StubTests\Model\PHPDefineConstant;
use ACSB\Vendor\StubTests\Model\PHPEnum;
use ACSB\Vendor\StubTests\Model\PHPFunction;
use ACSB\Vendor\StubTests\Model\PHPInterface;
use ACSB\Vendor\StubTests\Model\StubsContainer;
class PHPReflectionParser
{
    /**
     * @return StubsContainer
     * @throws \ReflectionException
     */
    public static function getStubs()
    {
        if (file_exists(__DIR__ . '/../../ReflectionData.json')) {
            $stubs = unserialize(file_get_contents(__DIR__ . '/../../ReflectionData.json'));
        } else {
            $stubs = new StubsContainer();
            $jsonData = json_decode(file_get_contents(__DIR__ . '/../TestData/mutedProblems.json'));
            $const_groups = get_defined_constants(\true);
            unset($const_groups['user']);
            $const_groups = CommonUtils::flattenArray($const_groups, \true);
            foreach ($const_groups as $name => $value) {
                if (class_exists('\ReflectionConstant')) {
                    $constant = (new PHPConstant())->readObjectFromReflection(new \ReflectionConstant($name));
                } else {
                    $constant = (new PHPDefineConstant())->readObjectFromReflection([$name, $value]);
                }
                $constant->readMutedProblems($jsonData->constants);
                $stubs->addConstant($constant);
            }
            foreach (get_defined_functions()['internal'] as $function) {
                $reflectionFunction = new ReflectionFunction($function);
                $phpFunction = (new PHPFunction())->readObjectFromReflection($reflectionFunction);
                $phpFunction->readMutedProblems($jsonData->functions);
                $stubs->addFunction($phpFunction);
            }
            foreach (get_declared_classes() as $clazz) {
                $reflectionClass = new ReflectionClass($clazz);
                if ($reflectionClass->isInternal()) {
                    if (method_exists($reflectionClass, 'isEnum') && $reflectionClass->isEnum()) {
                        $enum = (new PHPEnum())->readObjectFromReflection(new ReflectionEnum($clazz));
                        $enum->readMutedProblems($jsonData->enums);
                        $stubs->addEnum($enum);
                    } else {
                        $class = (new PHPClass())->readObjectFromReflection($reflectionClass);
                        $class->readMutedProblems($jsonData->classes);
                        $stubs->addClass($class);
                    }
                }
            }
            foreach (get_declared_interfaces() as $interface) {
                $reflectionInterface = new ReflectionClass($interface);
                if ($reflectionInterface->isInternal()) {
                    $phpInterface = (new PHPInterface())->readObjectFromReflection($reflectionInterface);
                    $phpInterface->readMutedProblems($jsonData->interfaces);
                    $stubs->addInterface($phpInterface);
                }
            }
        }
        return $stubs;
    }
}
