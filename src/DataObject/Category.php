<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Example\DataObject;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\GraphQL\Example\Dao\CategoryDaoInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class Category
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $parentid;

    public function __construct(
        string $id,
        string $name,
        string $parentid
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->parentid = $parentid;
    }

    /**
     * @Factory
     */
    public static function createCategory(string $id, string $name, ?string $parentid = null): self
    {
        $parentid = 'oxrootid';
        return new self(
            $id,
            $name,
            $parentid
        );
    }

    /**
     * @Field(outputType="ID")
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @Field()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getParent(): ?self
    {
        // TODO circular reference
        return ContainerFactory::getInstance()
            ->getContainer()
            ->get(CategoryDaoInterface::class)
            ->getCategoryById($this->parentid, 1);
    }

    /**
     * @Field()
     * @return null|Category[]
     */
    public function getChilds(): ?array
    {
        // TODO circular reference
        return ContainerFactory::getInstance()
            ->getContainer()
            ->get(CategoryDaoInterface::class)
            ->getCategoriesByParentId($this->id, 1);
    }
}
