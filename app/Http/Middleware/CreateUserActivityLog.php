<?php

namespace App\Http\Middleware;

use App\Models\FAQ;
use App\Models\FAQLog;
use App\Models\HelpTicket;
use App\Models\HelpTicketLog;
use App\Models\PropertyLog;
use App\Models\PropertyUnitLog;
use App\Models\SubZone;
use App\Models\SubZoneLog;
use App\Models\Tag;
use App\Models\TagLog;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\UserLog;
use App\Models\Zone;
use App\Models\ZoneLog;
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

                case 'Zone':
                    $data = new ZoneLog;
                    $zone = Zone::find($response->original['key']);

                    if (!$zone) {
                        $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', zone deleted';
                    } else {
                        $data->name = $zone->name;
                        $data->lat = $zone->lat;
                        $data->lng = $zone->lng;
                        $data->radius = $zone->radius;
                        $data->timezone = $zone->timezone;
                        $data->description = $zone->description;
                        $data->county_code = $zone->county_code;
                        $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method();
                    }

                    break;

                case 'SubZone':
                    $data = new SubZoneLog;
                    $subZone = SubZone::find($response->original['key']);

                    if (!$subZone) {
                        $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', sub-zone deleted';
                    } else {
                        $data->name = $subZone->name;
                        $data->lat = $subZone->lat;
                        $data->lng = $subZone->lng;
                        $data->radius = $subZone->radius;
                        $data->description = $subZone->description;
                        $data->nature_id = $subZone->nature_id;
                        $data->zone_id = $subZone->zone_id;
                        $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method();
                    }

                    break;

                case 'Property':
                    $data = new PropertyLog;

                    break;

                case 'PropertyUnit':
                    $data = new PropertyUnitLog;

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
