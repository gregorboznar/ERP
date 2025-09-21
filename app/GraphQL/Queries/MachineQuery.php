<?php

namespace App\GraphQL\Queries;

use App\Models\Machine;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MachineQuery
{
    public function machines($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Machine::all();
    }

    public function machine($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Machine::findOrFail($args['id']);
    }
}