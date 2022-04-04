<?php

namespace EscolaLms\Cmi5\Services;

use EscolaLms\Cmi5\Enums\Cmi5Enum;
use EscolaLms\Cmi5\Models\Cmi5;
use EscolaLms\Cmi5\Models\Cmi5Au;
use EscolaLms\Cmi5\Parsers\Cmi5AuParser;
use EscolaLms\Cmi5\Parsers\Cmi5Parser;
use EscolaLms\Cmi5\Services\Contracts\Cmi5ServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class Cmi5Service implements Cmi5ServiceContract
{
    public function upload(UploadedFile $file): Cmi5
    {
        return $this->parse($file);
    }

    private function parse(UploadedFile $file): Cmi5 {
        $zip = new ZipArchive();
        $zip->open($file);

        $data = $this->xmlToArray($zip->getFromName(Cmi5Enum::MANIFEST_FILE));

        $cmi5 = Cmi5Parser::parse($data[Cmi5Enum::CMI5_KEY]);
        $cmi5aus = Cmi5AuParser::parseCollection($data[Cmi5Enum::CMI5_AU_KEY]);

        $this->save($cmi5, $cmi5aus);
        $this->unzip($cmi5, $file);

        return $cmi5;
    }

    private function save(Cmi5 $cmi5, Collection $cmi5Aus): Cmi5 {
        // TODO move to repo
        DB::transaction(function () use($cmi5, $cmi5Aus) {
            $cmi5->save();
            $cmi5Aus->each(function (Cmi5Au $cmi5Au) use ($cmi5) {
                $cmi5Au->cmi5_id = $cmi5->getKey();
                $cmi5Au->save();
            });
        });

        return $cmi5;
    }

    private function unzip(Cmi5 $cmi5, UploadedFile $file): void {
        $rootDir = 'cmi5';
        $zip = new ZipArchive();
        $zip->open($file);

        // TODO get disk from config
        $destinationDir = Storage::path($rootDir . DIRECTORY_SEPARATOR . $cmi5->getKey());

        if (!Storage::exists($destinationDir)) {
            Storage::makeDirectory($destinationDir);
        }

        $zip->extractTo($destinationDir);
        $zip->close();
    }

    private function xmlToArray(string $xml): array
    {
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }
}
