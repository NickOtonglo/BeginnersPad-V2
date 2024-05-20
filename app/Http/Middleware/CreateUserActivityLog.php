<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\NotificationsController;
use App\Models\FAQ;
use App\Models\FAQLog;
use App\Models\HelpTicket;
use App\Models\HelpTicketLog;
use App\Models\Property;
use App\Models\PropertyLog;
use App\Models\PropertyReviewRemovalLog;
use App\Models\PropertyUnit;
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
                    $property = Property::where('slug', $response->original['key'])->first();

                    if (!$property) {
                        if ($response->original['comment']) {
                            $data->comment = $response->original['comment'];
                        } else {
                            $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', status set to deleted';
                        }
                    } else {
                        $data->name = $property->name;
                        $data->slug = $property->slug;
                        $data->lat = $property->lat;
                        $data->lng = $property->lng;
                        $data->status = $property->status;
                        $data->verified = $property->verified;
                        $data->description = $property->description;
                        $data->stories = $property->stories;
                        $data->thumbnail = $property->thumbnail;
                        $data->user_id = $property->user_id;
                        $data->sub_zone_id = $property->sub_zone_id;
                        $data->comment = $property->comment;
                        $data->parent_id = $property->parent_id;
                        
                        if ($response->original['comment']) {
                            $data->comment = $response->original['comment'];
                        } else {
                            $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', status set to '.$property->status;
                        }
                    }

                    break;

                case 'PropertyUnit':
                    $data = new PropertyUnitLog;
                    $unit = PropertyUnit::where('slug', $response->original['key'])->first();

                    if (!$unit) {
                        if ($response->original['comment']) {
                            $data->comment = $response->original['comment'];
                        } else {
                            $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', status set to deleted';
                        }
                    } else {
                        $data->name = $unit->name;
                        $data->slug = $unit->slug;
                        $data->description = $unit->description;
                        $data->price = $unit->price;
                        $data->init_deposit = $unit->init_deposit;
                        $data->init_deposit_period = $unit->init_deposit_period;
                        $data->story = $unit->story;
                        $data->floor_area = $unit->floor_area;
                        $data->bathrooms = $unit->bathrooms;
                        $data->bedrooms = $unit->bedrooms;
                        $data->disclaimer = $unit->disclaimer;
                        $data->status = $unit->status;
                        $data->thumbnail = $unit->thumbnail;
                        $data->property_id = $unit->property_id;
                        $data->comment = $unit->comment;
                        $data->parent_id = $unit->parent_id;                        
                        
                        if ($response->original['comment']) {
                            $data->comment = $response->original['comment'];
                        } else {
                            $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method().', status set to '.$unit->status;
                        }
                    }

                    break;

                case 'PropertyReviewRemovalReason':
                    $data = new PropertyReviewRemovalLog;

                    $log = $response->original['property_review_removal_reason'];

                    $data->review = $log->review;
                    $data->rating = $log->rating;
                    $data->author_id = $log->author_id;
                    $data->property_id = $log->property_id;
                    $data->removal_reason = $log->removal_reason;
                    $data->reason_details = $log->reason_details;

                    if ($response->original['comment']) {
                        $data->comment = $response->original['comment'];
                    } else {
                        $data->comment = $response->original['model'].' #'.$response->original['key'].': '.$request->method();
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

            if ($response->original['model'] == 'PropertyReviewRemovalReason') {
                app(NotificationsController::class)->sendReviewRemovedNotification($data);
            }
            if ($response->original['model'] == 'Property') {
                if ($data->status == 'published' || $data->status == 'rejected' || $data->status == 'suspended') {
                    $property = Property::where('slug', $data->slug)->first();
                    app(NotificationsController::class)->sendPropertyNotification($property, $data);
                }
            }
        }
            
        return $response;
    }
}
