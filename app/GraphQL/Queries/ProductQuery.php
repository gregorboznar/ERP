<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductQuery
{
    public function products($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Product::with(['seriesTenders', 'visualCharacteristics', 'measurementCharacteristics'])->get();
    }

    public function product($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Product::with(['seriesTenders', 'visualCharacteristics', 'measurementCharacteristics'])->findOrFail($args['id']);
    }
}
