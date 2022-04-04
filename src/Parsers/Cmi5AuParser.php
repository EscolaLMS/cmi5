<?php

namespace EscolaLms\Cmi5\Parsers;

use EscolaLms\Cmi5\Models\Cmi5Au;
use EscolaLms\Cmi5\Parsers\Contracts\Parser;
use Ramsey\Uuid\Uuid;

class Cmi5AuParser extends AbstractParser implements Parser
{
    public static function parse(array $data): Cmi5Au
    {
        $cmi5Au = new Cmi5Au();
        $cmi5Au->uuid = Uuid::uuid4();
        $cmi5Au->title = isset($data['title']['langstring']) ?? $data['title']['langstring'];
        $cmi5Au->iri = isset($data['@attributes']['id']) ?? $data['@attributes']['id'];
        $cmi5Au->url = isset($data['url']) ?? $data['url'];

        return $cmi5Au;
    }
}
