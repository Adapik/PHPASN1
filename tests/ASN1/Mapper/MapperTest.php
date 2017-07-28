<?php

namespace FG\Test\ASN1\Mapper;

use FG\ASN1\ExplicitlyTaggedObject;
use FG\ASN1\Identifier;
use FG\ASN1\Mapper\Mapper;
use FG\ASN1\Universal\Boolean;
use FG\ASN1\Universal\Integer;
use FG\ASN1\Universal\ObjectIdentifier;
use FG\ASN1\Universal\OctetString;
use FG\ASN1\Universal\PrintableString;
use FG\ASN1\Universal\Sequence;
use FG\ASN1\Universal\Set;
use PHPUnit\Framework\TestCase;

/**
 * Mapper Test
 */
class MapperTest extends TestCase
{
    public function testMap()
    {
        $map = ['type' => Identifier::INTEGER];

        $object       = Integer::create(123);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertEquals($mappedObject, $object);

        $map          = ['type' => Identifier::BOOLEAN];
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertNull($mappedObject, $object);
    }

    public function testMapAny()
    {
        $map = ['type' => Identifier::ANY];

        $object       = Integer::create(123);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertEquals($mappedObject, $object);
    }

    public function testMapSequence()
    {
        $map = [
            'type' => Identifier::SEQUENCE,
            'children' => [
                'oid1'  => ['type' => Identifier::OBJECT_IDENTIFIER],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
            ]
        ];

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            ObjectIdentifier::create('1.2.4'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertCount(2, $mappedObject);
    }

    public function testMapSequenceOrder()
    {
        $map = [
            'type' => Identifier::SEQUENCE,
            'children' => [
                'oid1'  => ['type' => Identifier::INTEGER],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
            ]
        ];

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            Integer::create(1),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertNull($mappedObject);
    }

    public function testMapSequenceWithOptionalElements()
    {
        $map = [
            'type' => Identifier::SEQUENCE,
            'children' => [
                'oid1'  => ['type' => Identifier::OBJECT_IDENTIFIER],
                'octetStringOptional' => [
                    'type'     => Identifier::OCTETSTRING,
                    'optional' => true
                ],
                'integerOptional1' => [
                    'type'     => Identifier::INTEGER,
                    'optional' => true
                ],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
                'integerOptional2' => [
                    'type'     => Identifier::INTEGER,
                    'optional' => true
                ],
            ]
        ];

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            OctetString::createFromString('testString'),
            Integer::create(3),
            ObjectIdentifier::create('1.2.3'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertCount(4, $mappedObject);

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            OctetString::createFromString('testString'),
            ObjectIdentifier::create('1.2.3'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertCount(3, $mappedObject);

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            ObjectIdentifier::create('1.2.4'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertCount(2, $mappedObject);

        $object       = Integer::create(123);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertNull($mappedObject, $object);

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);

        $this->assertNull($mappedObject);
    }

    public function testMapSequenceWithAny()
    {
        $map = [
            'type' => Identifier::SEQUENCE,
            'children' => [
                'oid1'  => ['type' => Identifier::ANY],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
            ]
        ];

        $object       = Sequence::create([
            ObjectIdentifier::create('1.2.3'),
            ObjectIdentifier::create('1.2.3.4'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertCount(2, $mappedObject);
    }

    public function testSequenceOf()
    {
        $map = [
            'type' => Identifier::SEQUENCE,
            'min'      => 1,
            'max'      => -1,
            'children' => [
                'type'     => Identifier::OBJECT_IDENTIFIER
            ]
        ];

        $object = Sequence::create([
            ObjectIdentifier::create('1.2.3.1'),
            ObjectIdentifier::create('1.2.3.2'),
            ObjectIdentifier::create('1.2.3.3'),
            ObjectIdentifier::create('1.2.3.4'),
        ]);

        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertCount(4, $mappedObject);

        $object = Sequence::create([
            ObjectIdentifier::create('1.2.3.1'),
            Boolean::create(true),
        ]);

        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNull($mappedObject);
    }

    public function testChoice()
    {
        $map = [
            'type' => Identifier::CHOICE,
            'children' => [
                'oid1'  => ['type' => Identifier::INTEGER],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
            ]
        ];

        $object       = Integer::create(1);
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNotNull($mappedObject);

        $object       = ObjectIdentifier::create('1.2.3');
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNotNull($mappedObject);

        $object       = PrintableString::createFromString('Test string');
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNull($mappedObject);
    }

    public function testMapSet()
    {
        $map = [
            'type' => Identifier::SET,
            'children' => [
                'oid1'  => ['type' => Identifier::INTEGER],
                'oid2'  => ['type' => Identifier::OBJECT_IDENTIFIER],
            ]
        ];

        $object       = Set::create([
            Integer::create(1),
            ObjectIdentifier::create('1.2.4'),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertCount(2, $mappedObject);

        $object       = Set::create([
            ObjectIdentifier::create('1.2.4'),
            Integer::create(1),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertCount(2, $mappedObject);

        $object       = Set::create([
            Integer::create(1),
        ]);
        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNull($mappedObject);
    }

    public function testSetOf()
    {
        $map = [
            'type' => Identifier::SET,
            'min'      => 1,
            'max'      => -1,
            'children' => [
                'type'     => Identifier::OBJECT_IDENTIFIER
            ]
        ];

        $object = Set::create([
            ObjectIdentifier::create('1.2.3.1'),
            ObjectIdentifier::create('1.2.3.2'),
        ]);

        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertCount(2, $mappedObject);

        $object = Set::create([
            ObjectIdentifier::create('1.2.3.1'),
            Boolean::create(true),
        ]);

        $mappedObject = (new Mapper())->map($object, $map);
        $this->assertNull($mappedObject);
    }

    public function testMapSetWithOptional()
    {
        $map = [
            'type' => Identifier::SET,
            'children' => [
                'oid'  => ['type' => Identifier::OBJECT_IDENTIFIER],
                'octetStringOptional' => [
                    'type'     => Identifier::OCTETSTRING,
                    'optional' => true
                ],
                'bool'  => ['type' => Identifier::BOOLEAN],
                'integerOptional' => [
                    'type'     => Identifier::BITSTRING,
                    'optional' => true
                ],
            ]
        ];

        $set = Set::create([
            Boolean::create(true),
            ObjectIdentifier::create('123.2.1'),
        ]);

        $mappedObject = (new Mapper())->map($set, $map);

        $this->assertCount(2, $mappedObject);
    }

    public function testMapExplicitlyTaggedObject()
    {
        $map = [
            'explicit' => true,
            'constant' => 0,
        ] + [
                'type'     => Identifier::SET,
                'children' => [
                    'oid'  => ['type' => Identifier::OBJECT_IDENTIFIER],
                    'bool'  => ['type' => Identifier::BOOLEAN],
                ]
            ];

        $set = Set::create([
            Boolean::create(true),
            ObjectIdentifier::create('123.2.1'),
        ]);

        $taggedObject = ExplicitlyTaggedObject::create(0, $set);
        $mappedObject = (new Mapper())->map($taggedObject, $map);
        $this->assertCount(2, $mappedObject);
    }
}