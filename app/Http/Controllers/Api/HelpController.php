<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;
use App\Http\Resources\HelpTicketResource;
use App\Http\Resources\HelpTopicResource;
use App\Models\FAQ;
use App\Models\HelpTicket;
use App\Models\HelpTopic;
use App\Models\User;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function getFaqs() {
        $faqs = FAQ::where('topic', 'help')->get();
        return FAQResource::collection($faqs);
    }
    
    public function storeFaqs(Request $request) {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        
        $data = new FAQ;
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->topic = 'help';
        $data->save();
        
        $response = [
            'property' => $data,
            'message' => "New FAQ added successfully.",
        ];
        
        return response($response, 201);
    }
    
    public function getFaq(FAQ $faq) {
        return new FAQResource($faq);
    }

    public function updateFaq(FAQ $faq, Request $request) {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        
        $data = $faq;
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->save();
        
        $response = [
            'property' => $data,
            'message' => "FAQ updated successfully.",
        ];
        
        return response($response, 201);
    }

    public function destroyFaq(FAQ $faq) {
        $faq->delete();
        return response()->noContent();
    }

    public function getTopics() {
        $topics = HelpTopic::get();
        return HelpTopicResource::collection($topics);
    }

    public function storeTicket(Request $request) {
        $rules = [
            'topic' => 'required',
            'description' => 'required'
        ];

        $email = '';

        if (!auth()->user()) {
            $rules['email'] = 'required';
            $email = $request->email;
        } else {
            $email = auth()->user()->email;
        }

        $request->validate($rules);

        // $topic = HelpTopic::where('id', $request->topic)->first()->category;

        $data = new HelpTicket;
        // $data->topic = $topic;
        $data->topic = $request->topic;
        $data->description = $request->description;
        $data->email = $email;
        $data->save();

        $response = [
            'help_ticket' => $data,
            'message' => "Ticket #".$data->id." created successfully.",
        ];
        
        return response($response, 201);
    }

    public function getTickets() {
        $tickets = HelpTicket::where('email', auth()->user()->email)->paginate(40);
        return HelpTicketResource::collection($tickets);
    }

    public function getTicketsWithStatus(string $status) {
        $tickets = HelpTicket::where('email', auth()->user()->email)->where('status', $status)->paginate(40);
        return HelpTicketResource::collection($tickets);
    }

    public function getTicketsAll() {
        $tickets = HelpTicket::when(request('search_global'), function($query) {
            $query->where(function($q) {
                $q->where('id', 'like', '%'.request('search_global').'%')
                  ->orWhere('topic', 'like', '%'.request('search_global').'%')
                  ->orWhere('description', 'like', '%'.request('search_global').'%')
                  ->orWhere('status', 'like', '%'.request('search_global').'%');
            });
        })->latest()->paginate(150);
        
        // $tickets = HelpTicket::latest()->paginate(50);
        return HelpTicketResource::collection($tickets);
    }

    public function getTicketsReps() {
        $repsList = HelpTicket::get()->pluck('assigned_to');
        return $repsList;
    }

    public function getTicket(HelpTicket $ticket) {
        $ticket = HelpTicket::where('id', $ticket->id)->first();
        return new HelpTicketResource($ticket);
    }

    public function getRepresentativeTickets(string $username) {
        
        $tickets = User::where('username', $username)->first()->assignedHelpTickets()->paginate(150);
        return HelpTicketResource::collection($tickets);
    }

    public function updateTicket(HelpTicket $ticket, Request $request) {
        $rules = [
            'topic' => 'required',
            'description' => 'required'
        ];

        $email = '';

        if (!auth()->user()) {
            $rules['email'] = 'required';
            $email = $request->email;
        } else {
            $email = auth()->user()->email;
        }

        $request->validate($rules);

        $data = $ticket;
        $data->topic = $request->topic;
        $data->description = $request->description;
        $data->email = $email;
        
        if ($ticket != 'open' && $ticket->assigned_to) {
            return response()->json([
                'message' => "This ticket has already been assigned to a representative and hence it cannot be updated.",
                'errors' => [
                    'favourite' => [
                        "The ticket status makes it uneditable",
                    ]
                ],
            ], 422);
        }
        
        $data->save();

        $response = [
            'help_ticket' => $data,
            'message' => "Ticket #".$data->id." updated successfully.",
        ];
        
        return response($response, 201);
    }

    public function destroyTicket(HelpTicket $ticket) {
        if ($ticket != 'open' && $ticket->assigned_to) {
            return response()->json([
                'message' => "This ticket has already been assigned to a representative and hence it cannot be updated.",
                'errors' => [
                    'favourite' => [
                        "The ticket status makes it uneditable",
                    ]
                ],
            ], 422);
        }

        $ticket->delete();
        return response()->noContent();
    }

    public function updateTicketStatus(HelpTicket $ticket, Request $request) {
        if ($request->status == 'open') {
            $ticket->status = 'open';
            $ticket->assigned_to = null;
        }
        if ($request->status == 'pending') {
            $ticket->status = 'pending';
            $ticket->assigned_to = auth()->user()->username;
        }
        if ($request->status == 'resolved') {
            $ticket->status = 'resolved';
            $ticket->assigned_to = auth()->user()->username;
        }
        if ($request->status == 'closed') {
            $ticket->status = 'closed';
            $ticket->assigned_to = auth()->user()->username;
        }
        $ticket->save();

        $response = [
            'help_ticket' => $ticket,
            'message' => "Ticket #".$ticket->id." updated successfully.",
        ];
        
        return response($response, 201);
    }
}
