<?php

namespace App\GraphQL\Queries;

use App\Models\SeriesTender;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SeriesTenderQuery
{
    public function seriesTenders($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return SeriesTender::with(['product', 'dieCastings', 'packagings'])->get();
    }

    public function seriesTender($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return SeriesTender::with(['product', 'dieCastings', 'packagings'])->findOrFail($args['id']);
    }
}
