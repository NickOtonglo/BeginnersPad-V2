<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;
use App\Models\FAQ;
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
}
