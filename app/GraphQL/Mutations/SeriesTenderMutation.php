<?php

namespace App\GraphQL\Mutations;

use App\Models\SeriesTender;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SeriesTenderMutation
{
    public function createSeriesTender($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return SeriesTender::create($args['input']);
    }

    public function updateSeriesTender($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $seriesTender = SeriesTender::findOrFail($args['id']);
        $seriesTender->update($args['input']);

        return $seriesTender;
    }

    public function deleteSeriesTender($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $seriesTender = SeriesTender::findOrFail($args['id']);
        $seriesTender->delete();

        return [
            'message' => 'Series Tender deleted successfully'
        ];
    }
}
