<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Example\Controller;

use OxidEsales\EshopCommunity\Application\Model\Category as CategoryModel;
use OxidEsales\GraphQL\Base\Exception\NotFoundException;
use OxidEsales\GraphQL\Example\DataObject\Category as CategoryDataObject;
use OxidEsales\GraphQL\Example\DataObject\CategoryFilter;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

class Category
{
    /**
     * category by ID
     *
     * @Query()
     */
    public function category(string $id): CategoryDataObject
    {
        $category = oxNew(CategoryModel::class);
        if (!$category->load($id)) {
            throw new NotFoundException('Category with id "' . $id . '" does not exist');
        }
        return CategoryDataObject::createFromModel($category);
    }

    /**
     * category list by parent ID
     *
     * @Query()
     * @return CategoryDataObject[]
     */
    public function categories(?CategoryFilter $filter = null): array
    {
        if ($parentid === null) {
            $parentid = 'oxrootid';
        }
        return [];
    }

    /**
     * create a category
     *
     * @Mutation()
     * @Logged()
     * @Right("CATEGORY_CREATE")
     */
    public function categoryCreate(CategoryDataObject $category): CategoryDataObject
    {
        $category = $category->createModel();
        if (!$category->save()) {
            return 'SDF';
        }
        return CategoryDataObject::createFromModel($category);
    }
}
