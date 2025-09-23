<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ProductMutation
{
    public function createProduct($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Product::create($args['input']);
    }

    public function updateProduct($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $product = Product::findOrFail($args['id']);
        $product->update($args['input']);

        return $product;
    }

    public function deleteProduct($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $product = Product::findOrFail($args['id']);
        $product->delete();

        return [
            'message' => 'Product deleted successfully'
        ];
    }
}
