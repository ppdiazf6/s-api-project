<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$notes = Note::query()
            ->title($request->title)
            ->user($request->user_id)
            ->paginate(
                $request->get('per_page',10)
            );
			
        //
		return response()->json($notes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
		$note = Note::create([...$request->validated(), 'user_id' => auth()->id()]);
        //
        return response()->json($note, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
		$note = Note::find($id);
        
		if (!$note) {
			return response()->json([
				'message' => 'No se pudo encontrar la Nota'
			], 404);
		}
        //
        return response()->json($note, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, $id)
    {
		$note = Note::find($id);
		
        if (!$note) {
			return response()->json([
				'message' => 'Nota no encontrada'
			], 404);
		}
        $note->update($request->validated());
        //
        return response()->json($note, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
		$note = Note::find($id);
		
        if (!$note) {
			return response()->json([
				'message' => 'Nota no encontrada'
			], 404);
		}
		
        $note->delete();
        //
        return response()->json([
            'message' => 'Nota elimanda correctamente'
        ],200);
    }
}
