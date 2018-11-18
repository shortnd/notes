<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response(Note::latest()->get());
        $requestQuery = request()->query();
        $condition = array_key_exists('type', $requestQuery) && $requestQuery['type'] === 'favourite';
        $allNotes = $condition ? Note::where('is_favourite', true)->latest()->get() : Note::latest()->get();
        return response()->json($allNotes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedNoteData = $request->validate([
            'title' => 'required',
            'is_favourite' => 'required'
        ]);

        $note = Note::create($validatedNoteData);

        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response(Note::findOrFail($id)->update($request->only('title')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(Note::findOrFail($id)->delete());
    }

    /**
     * @param int id
     * @return \Illuminate\Http\Response
     */
    public function toggleFavorite($id)
    {
        $note = Note::findOrFail($id);
        $note = $note->update(['is_favourite' => !$note->is_favourite]);

        return response()->json($note);
    }
}
