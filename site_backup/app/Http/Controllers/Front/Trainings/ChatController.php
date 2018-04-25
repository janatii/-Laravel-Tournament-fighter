<?php

namespace App\Http\Controllers\Front\Trainings;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        $this->validate($request, [
            'message' => 'required|string|max:255',
        ]);
        
        $userInSquad1 = $match->squad1->members->contains($user) || $match->squad1->manager_id == $user->id;
        $userInSquad2 = $match->squad2->members->contains($user) || $match->squad2->manager_id == $user->id;
        
        $userIsStaff = $user->canJudgeMatch();
        if (!$userIsStaff) {
            if (!$userInSquad1 && !$userInSquad2) {
                abort(403);
            }
    
            if (!in_array($match->status, ['IN_PROGRESS', 'WAIT_CONFIRM'])) {
                $twelveHoursBefore = \Carbon\Carbon::now()->subHours(12);
                if ($match->status != 'FINISH' || $match->updated_at->lt($twelveHoursBefore)) {
                    return response()->json(['message' => trans('app.front.trainings.show.error-chat-match-closed')], 403);
                }
            }
        }
        
        $message = $request->input('message');
        
        $chatMessage = ChatMessage::create([
            'match_id' => $match->id,
            'message' => htmlspecialchars($message),
            'user_id' => $user->id,
            'squad_id' => ($userInSquad1 ? $match->squad1_id : ($userInSquad2 ? $match->squad2_id : null)),
            'is_staff' => $userIsStaff,
            'is_event' => false,
        ]);
        
        event(new \App\Events\NewChatMessageEvent($chatMessage));
        
        return response()->json(['message' => 'success']);
    }
    
    public function getMessages(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        $userInSquad1 = $match->squad1->members->contains($user) || $match->squad1->manager_id == $user->id;
        $userInSquad2 = $match->squad2->members->contains($user) || $match->squad2->manager_id == $user->id;
        
        $userIsStaff = $user->canJudgeMatch();
        if (!$userIsStaff && !$userInSquad1 && !$userInSquad2) {
            abort(403);
        }
        
        $messages = ChatMessage::where('match_id', $match->id)->orderBy('id')->get()->map(function(ChatMessage $message) {
            $data = [
                'id' => $message->id,
                'message' => $message->message,
                'squad_id' => $message->squad_id,
                'is_staff' => $message->is_staff,
                'is_event' => $message->is_event,
                'created_at' => $message->created_at,
            ];
            if ($message->user_id) {
                $data['user'] = [
                    'id' => $message->user_id,
                    'username' => $message->user->username,
                ];
            }
            return $data;
        });
        
        return response()->json($messages);
    }
}
