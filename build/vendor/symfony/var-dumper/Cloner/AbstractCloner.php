<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ACSB\Vendor\Symfony\Component\VarDumper\Cloner;

use ACSB\Vendor\Symfony\Component\VarDumper\Caster\Caster;
use ACSB\Vendor\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements ClonerInterface
{
    public static array $defaultCasters = ['__PHP_Incomplete_Class' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\Caster', 'castPhpIncompleteClass'], 'AddressInfo' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AddressInfoCaster', 'castAddressInfo'], 'Socket' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SocketCaster', 'castSocket'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\CutStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\CutArrayStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'castCutArray'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\ConstStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'castStub'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\EnumStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'castEnum'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\ScalarStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'castScalar'], 'Fiber' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\FiberCaster', 'castFiber'], 'Closure' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClosure'], 'Generator' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ReflectionCaster', 'castZendExtension'], 'ACSB\Vendor\Doctrine\Common\Persistence\ObjectManager' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Doctrine\Common\Proxy\Proxy' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castCommonProxy'], 'ACSB\Vendor\Doctrine\ORM\Proxy\Proxy' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castOrmProxy'], 'ACSB\Vendor\Doctrine\ORM\PersistentCollection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DoctrineCaster', 'castPersistentCollection'], 'ACSB\Vendor\Doctrine\Persistence\ObjectManager' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'DOMException' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castException'], 'ACSB\Vendor\Dom\Exception' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castException'], 'DOMStringList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'DOMNameList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'DOMImplementation' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castImplementation'], 'ACSB\Vendor\Dom\Implementation' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'DOMNode' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNode'], 'ACSB\Vendor\Dom\Node' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocument'], 'ACSB\Vendor\Dom\XMLDocument' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castXMLDocument'], 'ACSB\Vendor\Dom\HTMLDocument' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castHTMLDocument'], 'DOMNodeList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'ACSB\Vendor\Dom\NodeList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'ACSB\Vendor\Dom\DTDNamedNodeMap' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castLength'], 'DOMCharacterData' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castCharacterData'], 'ACSB\Vendor\Dom\CharacterData' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castAttr'], 'ACSB\Vendor\Dom\Attr' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castAttr'], 'DOMElement' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castElement'], 'ACSB\Vendor\Dom\Element' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castElement'], 'DOMText' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castText'], 'ACSB\Vendor\Dom\Text' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castText'], 'DOMDocumentType' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocumentType'], 'ACSB\Vendor\Dom\DocumentType' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNotation'], 'ACSB\Vendor\Dom\Notation' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castNotation'], 'DOMEntity' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castEntity'], 'ACSB\Vendor\Dom\Entity' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castProcessingInstruction'], 'ACSB\Vendor\Dom\ProcessingInstruction' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DOMCaster', 'castXPath'], 'XMLReader' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castErrorException'], 'Exception' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castException'], 'Error' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castError'], 'ACSB\Vendor\Symfony\Bridge\Monolog\Logger' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Symfony\Component\DependencyInjection\ContainerInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Symfony\Component\EventDispatcher\EventDispatcherInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Symfony\Component\HttpClient\AmpHttpClient' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'ACSB\Vendor\Symfony\Component\HttpClient\CurlHttpClient' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'ACSB\Vendor\Symfony\Component\HttpClient\NativeHttpClient' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClient'], 'ACSB\Vendor\Symfony\Component\HttpClient\Response\AmpResponse' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'ACSB\Vendor\Symfony\Component\HttpClient\Response\AmpResponseV4' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'ACSB\Vendor\Symfony\Component\HttpClient\Response\AmpResponseV5' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'ACSB\Vendor\Symfony\Component\HttpClient\Response\CurlResponse' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'ACSB\Vendor\Symfony\Component\HttpClient\Response\NativeResponse' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castHttpClientResponse'], 'ACSB\Vendor\Symfony\Component\HttpFoundation\Request' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castRequest'], 'ACSB\Vendor\Symfony\Component\Uid\Ulid' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUlid'], 'ACSB\Vendor\Symfony\Component\Uid\Uuid' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castUuid'], 'ACSB\Vendor\Symfony\Component\VarExporter\Internal\LazyObjectState' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SymfonyCaster', 'castLazyObjectState'], 'ACSB\Vendor\Symfony\Component\VarDumper\Exception\ThrowingCasterException' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castThrowingCasterException'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\TraceStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castTraceStub'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\FrameStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castFrameStub'], 'ACSB\Vendor\Symfony\Component\VarDumper\Cloner\AbstractCloner' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Symfony\Component\ErrorHandler\Exception\FlattenException' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castFlattenException'], 'ACSB\Vendor\Symfony\Component\ErrorHandler\Exception\SilencedErrorContext' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ExceptionCaster', 'castSilencedErrorContext'], 'ACSB\Vendor\Imagine\Image\ImageInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ImagineCaster', 'castImage'], 'ACSB\Vendor\Ramsey\Uuid\UuidInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\UuidCaster', 'castRamseyUuid'], 'ACSB\Vendor\ProxyManager\Proxy\ProxyInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\PHPUnit\Framework\MockObject\MockObject' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\PHPUnit\Framework\MockObject\Stub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Prophecy\Prophecy\ProphecySubjectInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'ACSB\Vendor\Mockery\MockInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\StubCaster', 'cutInternals'], 'PDO' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdo'], 'PDOStatement' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileInfo'], 'SplFileObject' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castFileObject'], 'SplHeap' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'], 'SplObjectStorage' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castHeap'], 'OuterIterator' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castOuterIterator'], 'WeakMap' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castWeakMap'], 'WeakReference' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SplCaster', 'castWeakReference'], 'Redis' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedis'], 'ACSB\Vendor\Relay\Relay' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedis'], 'RedisArray' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DateCaster', 'castDateTime'], 'DateInterval' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DateCaster', 'castInterval'], 'DateTimeZone' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DateCaster', 'castTimeZone'], 'DatePeriod' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DateCaster', 'castPeriod'], 'GMP' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\GmpCaster', 'castGmp'], 'MessageFormatter' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\MemcachedCaster', 'castMemcached'], 'ACSB\Vendor\Ds\Collection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DsCaster', 'castCollection'], 'ACSB\Vendor\Ds\Map' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DsCaster', 'castMap'], 'ACSB\Vendor\Ds\Pair' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DsCaster', 'castPair'], 'ACSB\Vendor\Symfony\Component\VarDumper\Caster\DsPairStub' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\DsCaster', 'castPairStub'], 'mysqli_driver' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\MysqliCaster', 'castMysqliDriver'], 'CurlHandle' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\CurlCaster', 'castCurl'], 'ACSB\Vendor\Dba\Connection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], ':dba' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], ':dba persistent' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castDba'], 'GdImage' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\GdCaster', 'castGd'], 'SQLite3Result' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\SqliteCaster', 'castSqlite3Result'], 'ACSB\Vendor\PgSql\Lob' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLargeObject'], 'ACSB\Vendor\PgSql\Connection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castLink'], 'ACSB\Vendor\PgSql\Result' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\PgSqlCaster', 'castResult'], ':process' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castProcess'], ':stream' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'], 'OpenSSLAsymmetricKey' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslAsymmetricKey'], 'OpenSSLCertificateSigningRequest' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslCsr'], 'OpenSSLCertificate' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\OpenSSLCaster', 'castOpensslX509'], ':persistent stream' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStream'], ':stream-context' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\XmlResourceCaster', 'castXml'], 'RdKafka' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castRdKafka'], 'ACSB\Vendor\RdKafka\Conf' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castConf'], 'ACSB\Vendor\RdKafka\KafkaConsumer' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castKafkaConsumer'], 'ACSB\Vendor\RdKafka\Metadata\Broker' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castBrokerMetadata'], 'ACSB\Vendor\RdKafka\Metadata\Collection' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castCollectionMetadata'], 'ACSB\Vendor\RdKafka\Metadata\Partition' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castPartitionMetadata'], 'ACSB\Vendor\RdKafka\Metadata\Topic' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicMetadata'], 'ACSB\Vendor\RdKafka\Message' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castMessage'], 'ACSB\Vendor\RdKafka\Topic' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopic'], 'ACSB\Vendor\RdKafka\TopicPartition' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicPartition'], 'ACSB\Vendor\RdKafka\TopicConf' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\RdKafkaCaster', 'castTopicConf'], 'ACSB\Vendor\FFI\CData' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\FFICaster', 'castCTypeOrCData'], 'ACSB\Vendor\FFI\CType' => ['ACSB\Vendor\Symfony\Component\VarDumper\Caster\FFICaster', 'castCTypeOrCData']];
    protected int $maxItems = 2500;
    protected int $maxString = -1;
    protected int $minDepth = 1;
    /**
     * @var array<string, list<callable>>
     */
    private array $casters = [];
    /**
     * @var callable|null
     */
    private $prevErrorHandler;
    private array $classInfo = [];
    private int $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(?array $casters = null)
    {
        $this->addCasters($casters ?? static::$defaultCasters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters(array $casters): void
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     */
    public function setMaxItems(int $maxItems): void
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     */
    public function setMaxString(int $maxString): void
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     */
    public function setMinDepth(int $minDepth): void
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param int $filter A bit field of Caster::EXCLUDE_* constants
     */
    public function cloneVar(mixed $var, int $filter = 0): Data
    {
        $this->prevErrorHandler = set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = gc_enabled()) {
            gc_disable();
        }
        try {
            return new Data($this->doClone($var));
        } finally {
            if ($gc) {
                gc_enable();
            }
            restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     */
    abstract protected function doClone(mixed $var): array;
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     */
    protected function castObject(Stub $stub, bool $isNested): array
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (str_contains($class, "@anonymous\x00")) {
            $stub->class = get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = method_exists($class, '__debugInfo');
            foreach (class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '') . '⚠' => new ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     */
    protected function castResource(Stub $stub, bool $isNested): array
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '') . '⚠' => new ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
