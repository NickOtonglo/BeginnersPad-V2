<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return TransactionResource::collection($user->transactions);
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
    public function store(Request $request)
    {
        $data = new Transaction();
        $data->confirmation_code = $request->confirmation_code;
        $data->amount = $request->amount;
        $data->comment = $request->comment;
        $data->user_id = $request->user_id;
        $data->payment_gateway_id = $request->payment_gateway_id;
        $data->save();

        $user = User::find($data->user_id);
        $comment = '';

        if ($user->userCredit) {
            app(UserCreditController::class)->store(0, $user);
        }

        app(UserCreditController::class)->update($user->userCredit, $request->amount, $user->userCredit->auto_pay, $user);

        $response = [
            'transaction' => $data,
            'model' => 'Transaction',
            'key' => $data->id,
            'message' => "Transaction worth KES ".$data->amount." for user @".$user->username." completed successfully",
            'comment' => $comment,
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
