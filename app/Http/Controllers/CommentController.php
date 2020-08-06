<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message'   => 'required|max:50',
            'ticket_id' => 'required|exists:App\Ticket,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $comment = Comment::create($data);

        if ($comment) {
            return response()->json($comment->load('submitter'), 200);
        }
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json('Comentario eliminado del sistema', 200);
    }
}
