<?php

namespace App\Http\Middleware;

use App\Models\FAQ;
use App\Models\FAQLog;
use App\Models\HelpTicket;
use App\Models\HelpTicketLog;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\UserLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Perform action

        if (isset($response->original['model'])) {
            switch ($response->original['model']) {
                case 'HelpTicket':
                    $data = new HelpTicketLog;
                    $ticket = HelpTicket::find($response->original['key']);
    
                    if (!$ticket) {
                        $data->status = 'open';
                        $data->assigned_to = null;
                    } else {
                        if ($request->topic) {
                            $data->topic = $request->topic;
                            $data->description = $request->description;
                            $data->status = $ticket->status;
                            $data->assigned_to = $ticket->assigned_to;
                        } else {
                            $data->topic = $ticket->topic;
                            $data->description = $ticket->description;
                            $data->status = $request->status;
                            $data->assigned_to = $request->assigned_to;
                        }
                    }
                    $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', status set to '.$request->status;

                    break;
    
                case 'FAQ':
                    $data = new FAQLog;
                    $faq = FAQ::find($response->original['key']);
    
                    if (!$faq) {
                        $data->topic = 'help';
                    } else {
                        $data->topic = $faq->topic;
                    }
                    $data->question = $request->question;
                    $data->answer = $request->answer;
                    $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method();

                    break;
                    
                case 'User':
                    $data = new UserLog;
                    $user = User::where('username', $response->original['key'])->first();
    
                    // $data->user_id = $user->id;
                    // if ($request->status) {
                    //     $data->firstname = $user->firstname;
                    //     $data->lastname = $user->lastname;
                    //     $data->email = $user->email;
                    //     $data->username = $user->username;
                    //     $data->telephone = substr($request->telephone, -12);
                    //     $data->status = $request->status;
                    //     $data->comment = $response->original['model'].' @'.$response->original['key'].': '.$request->method().', status set to '.$request->status;
                    // } else {
                    //     $data->firstname = $request->firstname;
                    //     $data->lastname = $request->lastname;
                    //     $data->email = $request->email;
                    //     $data->username = $request->username;
                    //     $data->telephone = $request->telephone;
                    //     $data->status = $user->status;
                    //     $data->comment = $response->original['model'].' @'.$response->original['key'].': '.$request->method();
                    // }

                    if (!$user) {
                        $data->comment = $response->original['model'].' @'.$response->original['key'].': '.$request->method().', status set to deleted';
                    } else {
                        $data->user_id = $user->id;
                        $data->firstname = $user->firstname;
                        $data->lastname = $user->lastname;
                        $data->email = $user->email;
                        $data->username = $user->username;
                        $data->telephone = $user->telephone;
                        $data->status = $user->status;
                        $data->comment = $response->original['model'].' @'.$response->original['key'].': '.$request->method().', status set to '.$user->status;
                    }

                    break;

                default:
                # code...
                break;
            }  
                
            // $log = new UserActivityLog;
            $log = [];
            if (!auth()->user() && $request->email) {
                $log['email'] = $request->email;
                $log['is_registered'] = false;
            } else {
                $log['email'] = auth()->user()->email;
                $log['is_registered'] = true;
            }
            $log['ip_address'] = $request->ip();
            $log['url'] = $request->fullUrl();
            $log['method'] = $request->method();
            $log['client'] = $request->header('user_agent');
            $log['model'] = $response->original['model'];
            $log['model_id'] = $response->original['key'];
            $data->parent_id = UserActivityLog::create($log)->id;
            
            $data->save();
        }
            
        return $response;
    }
}
