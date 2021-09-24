<?php

namespace App\Services;

use App\Http\Requests\PredefinedMessageUpdateRequest;
use App\Models\PredefinedMessage;

class PredefinedMessageService
{
    public static function update($messageId, PredefinedMessageUpdateRequest $request)
    {
        $recruitment = PredefinedMessage::findOrFail($messageId);
        $input = $request->validated();
        $recruitment->fill($input)->save();

        return $recruitment;
    }
}
