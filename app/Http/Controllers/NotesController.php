<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function get(Request $request)
    {
        $notes = Note::where('candidate_id', $request->candidateId)->with('user')->orderBy('created_at', 'ASC')->get();
        return response()->json($notes);
    }

    public function create(Request $request)
    {
        $note = new Note;
        $note->candidate_id = $request->candidate_id;
        $note->body = $request->body;
        $note->user_id = \Auth::id();
        $note->save();

        $note = Note::with('user')->find($note->id);
        return response()->json($note, 201, ['Location'=>'/notes/'.$note->id]);
    }
}
