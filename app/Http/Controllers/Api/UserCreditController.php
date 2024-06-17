<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCreditResource;
use App\Models\User;
use App\Models\UserCredit;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Decimal;

class UserCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credit = auth()->user()->userCredit;
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
    public function store(Decimal $amount, User $user)
    {
        $data = new UserCredit();
        $data->user_id = $user->id;
        $data->credit = $amount;
        $data->save();
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserCreditResource($user->userCredit);
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
    public function update(UserCredit $data, Decimal $amount = 0, bool $autoPay = true, User $user)
    {
        $credit = UserCredit::find($data->id);
        
        $data->amount = $data->amount + $amount;
        $data->auto_pay = $autoPay;

        $comment = '';
        if ($credit->amount != $data->amount) {
            $comment = "top-up";
        }
        if ($credit->auto_pay != $data->auto_pay) {
            $comment = "auto_pay update";
        }

        $data->save();

        $response = [
            'user_credit' => $data,
            'model' => 'UserCredit',
            'key' => $data->id,
            'message' => "Credit account for '".$user->name."' updated successfully.",
            'comment' => $comment,
        ];
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
