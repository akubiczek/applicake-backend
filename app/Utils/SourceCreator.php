<?php

namespace App\Utils;

use App\Models\Source;
use Illuminate\Support\Str;

class SourceCreator
{
    const SOURCE_KEY_MAXLENGTH = 6;

    public static function create(array $data): Source
    {
        $source = new Source();
        $source->name = $data['name'];
        $source->recruitment_id = $data['recruitment_id'];
        $source->key = self::generateKey();
        $source->save();

        return Source::find($source->id);
    }

    private static function generateKey()
    {
        do {
            $key = strtoupper(Str::random(self::SOURCE_KEY_MAXLENGTH));
            $sources = Source::where('key', $key)->count();
        } while ($sources > 0);

        return $key;
    }
}
