<?php

namespace EscolaLms\Cmi5\Parsers;

use EscolaLms\Cmi5\Models\Cmi5;
use EscolaLms\Cmi5\Parsers\Contracts\Parser;
use Ramsey\Uuid\Uuid;

class Cmi5Parser extends AbstractParser implements Parser
{
    public static function parse(array $data): Cmi5
    {
        $cmi5 = new Cmi5();
        $cmi5->uuid = Uuid::uuid4();
        $cmi5->title = isset($data['title']['langstring']) ??$data['title']['langstring'];
        $cmi5->iri = isset($data['@attributes']['id']) ?? $data['@attributes']['id'];

        return $cmi5;
    }
}
