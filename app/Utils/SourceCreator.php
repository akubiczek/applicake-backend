<?php

namespace App\Utils;

use App\Models\Source;

class SourceCreator
{
    const SOURCE_KEY_MAXLENGTH = 8;

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
            $key = strtoupper(substr(md5(uniqid()), 0, self::SOURCE_KEY_MAXLENGTH));
            $sources = Source::where('key', $key)->count();
        } while ($sources > 0);

        return $key;
    }
}
