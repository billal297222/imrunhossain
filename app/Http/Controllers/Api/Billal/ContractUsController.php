<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\ContactUs;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    use ApiResponse;
public function submitContactUsForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'messege' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $contactUs = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'messege' => $request->messege,
            'user_id' => auth()->id(),
        ]);

        return $this->success('Your message has been submitted successfully.', $contactUs, 201);
    }

}
