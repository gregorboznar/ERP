<?php

namespace App\GraphQL\Mutations;

use App\Models\Machine;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MachineMutation
{
    public function createMachine($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Machine::create($args['input']);
    }

    public function updateMachine($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $machine = Machine::findOrFail($args['id']);
        $machine->update($args['input']);
        
        return $machine;
    }

    public function deleteMachine($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $machine = Machine::findOrFail($args['id']);
        $machine->delete();
        
        return [
            'message' => 'Machine deleted successfully'
        ];
    }
}