<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Http\Resources\ChapterResource;
use App\Http\Resources\SingleChapterResource;
use Illuminate\Http\Request;

class ChapterApiController extends Controller
{
    public function index($book_id)
    {
        $chapters = Chapter::where('book_id', $book_id)
                    ->where('status', '1')
                    ->where('deleted_at', null)
                    ->paginate(10);

        return ChapterResource::collection($chapters);
    }

    public function show($chapter_id)
    {
        $chapter = Chapter::findOrFail($chapter_id);
        return new SingleChapterResource($chapter);
    }
    
    public function update($chapter_id)
    {
        return response()->json(["message" => "Not implemented yet!"]);
    }
}
