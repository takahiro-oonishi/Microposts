<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function store(Request $request, $id)
    {
    	$this->validate($request, [
            'content' => 'required|max:191',
        ]);
        
        $toId = $id;
        
        \Auth::user()->messageSend($toId,$request->content);
    
        return back();
    	
    }

    public function destroy($id)
    {
    	$message = \App\Message::find($id);///???

        if (\Auth::id() === $message->user->id) 
        {
            $message->delete();
        }
    	
        return back();
    }
}
