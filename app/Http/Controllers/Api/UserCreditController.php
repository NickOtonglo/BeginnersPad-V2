<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCreditResource;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\UserCredit;
use App\Models\UserCreditLog;
use Illuminate\Http\Request;

class UserCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credit = auth()->user()->credit;
        return $credit;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(float $amount, User $user, string $source = null)
    {
        $data = new UserCredit();
        $data->user_id = $user->id;
        $data->credit = $amount;
        $data->save();

        if (!$source) {
            $comment = '';

            $response = [
                'user_credit' => $data,
                'model' => 'UserCredit',
                'key' => $data->id,
                'message' => "Credit account for '".$user->name."' created successfully.",
                'comment' => $comment,
            ];
            return response($response, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        return new UserCreditResource($user->credit);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCredit $data, float $amount = 0, bool $autoPay = false, User $user, string $source = null, bool $log = false)
    {
        $credit = UserCredit::find($data->id);
        
        $data->credit = $data->credit + $amount;
        $data->auto_pay = $autoPay;

        $comment = '';
        if ($credit->amount != $data->amount) {
            $comment = "top-up";
        }
        if ($credit->auto_pay != $data->auto_pay) {
            $comment = "auto_pay update";
        }

        $data->save();

        if ($log) {
            $this->createLog($data, $comment, 'UserCredit', $data->id);
        }

        if (!$source){
            $response = [
                'user_credit' => $data,
                'model' => 'UserCredit',
                'key' => $data->id,
                'message' => "Credit account for '".$user->name."' updated successfully.",
                'comment' => $comment,
            ];
            return response($response, 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function prePost(Request $request, string $username = '') {
        $user = '';
        if (!$username) {
            $user = auth()->user();
        } else {
            $user = User::where('username', $username)->first();
        }
        $credit = '';
        $amount = 0;
        $autoPay = '';

        if ($user->credit) {
            $credit = $user->credit;
            if ($request->auto_pay) {
                $autoPay = $request->auto_pay;
            }
            if ($request->amount) {
                $amount = $request->amount;
            }
            $this->update($credit, $amount, $autoPay, $user);
        } else {
            $credit = new UserCredit();
            $autoPay = $request->auto_pay;
            $amount = $request->amount;
            $this->store($amount, $user);
        }
    }

    public function doesUserHaveCreditAccount() {
        $user = auth()->user();

        if ($user->credit) {
            return true;
        }
        return false;
    }

    public function createLog(UserCredit $credit, $comment, $model, $key) {
        $data = new UserCreditLog();

        $data->user_id = $credit->user_id;
        $data->credit = $credit->credit;
        $data->auto_pay = $credit->auto_pay;

        if ($comment) {
            $data->comment = $comment;
        } else {
            $data->comment = $model.' #'.$key.': '.request()->method();
        }

        $log = [];
        if (!auth()->user() && request()->email) {
            $log['email'] = request()->email;
            $log['is_registered'] = false;
        } else {
            $log['email'] = auth()->user()->email;
            $log['is_registered'] = true;
        }
        $log['ip_address'] = request()->ip();
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['client'] = request()->header('user_agent');
        $log['model'] = $model;
        $log['model_id'] = $key;
        $data->parent_id = UserActivityLog::create($log)->id;

        $data->save();

        // app(NotificationsController::class)->sendUserCreditNotification($credit, $comment);
    }
}
