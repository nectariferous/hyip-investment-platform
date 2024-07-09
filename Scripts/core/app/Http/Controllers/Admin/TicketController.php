<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        $user = User::find($request->user);

        $tickets = Ticket::query();

        if($user){
            $tickets->where('user_id',$user->id);
        }
      
        $data['pageTitle'] = "All Ticket";
        $data['navTicketActiveClass'] = "active";
        $data['ticketList'] = "active";
        $data['tickets'] = $tickets->with('ticketReplies')->when($request->search,function($item) use($request){$item->where('support_id','LIKE','%'.$request->search.'%');})->latest()->paginate();

        return view('backend.ticket.list')->with($data);
    }

    public function pendingList(Request $request)
    {
        $data['pageTitle'] = "Pending Ticket";
        $data['navTicketActiveClass'] = "active";
        $data['pendingTicket'] = "active";
        $data['tickets'] = Ticket::whereStatus(2)->when($request->search,function($item) use($request){$item->where('support_id','LIKE','%'.$request->search.'%');})->latest()->paginate();

        return view('backend.ticket.pending_list')->with($data);
    }

    public function show($id)
    {
        $data['pageTitle'] = "Support Ticket Discussion";
        $data['navTicketActiveClass'] = "active";
        $data['ticket'] = Ticket::find($id);
        $data['ticket_reply'] = TicketReply::whereTicketId($data['ticket']->id)->latest()->get();

        return view('backend.ticket.show')->with($data);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket){
            $all_reply = TicketReply::whereTicketId($id)->get();
            if (count($all_reply) > 0){
                foreach ($all_reply as $reply)
                {
                    $item = TicketReply::find($reply->id);
                    if ($item->file){
                        removeFile(filePath('Ticket') . @$reply->file);
                    }
                    $item->delete();
                }
            }
            $ticket->delete();
        }

        return redirect()->back()->with('success', 'Ticket Deleted Successfully');
    }

    public function reply(Request $request)
    {

       
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $reply = new TicketReply();
        $reply->ticket_id = $request->ticket_id;
        $reply->admin_id = Auth::guard('admin')->user()->id;
        $reply->message = $request->message;

       
        if ($request->has('image')){
            $image = uploadImage($request->image, filePath('Ticket'));
            $reply->file = $image;
        }

        $reply->save();

        Ticket::findOrFail($request->ticket_id)->update(['status' => 3]);

        return redirect()->back()->with('success', 'Reply Created Successfully');
    }
}
