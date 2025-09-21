<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserQuery
{
    public function me($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return $context->user();
    }
}