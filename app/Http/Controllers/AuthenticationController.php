<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpGenerationRequest;
use App\Http\Requests\PhoneNumberVerificationRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use App\Notifications\VerifyUserEmail;
use App\Traits\GlobalData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AuthenticationController extends BaseController
{
    use GlobalData;

    public function store(StoreUserRequest $storeUserRequest): JsonResponse
    {
        $data = $storeUserRequest->all();
        $otp = $this->generateOtp();
        $data['otp'] = $otp;
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);
        $this->sendOtpViaSms($user, $otp);
        return $this->buildSuccessResponse($user, "User profile created successfully");
    }

    public function verifyMobileNumber(PhoneNumberVerificationRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->firstWhere('phoneNumber', '=', $data['phoneNumber']);
        if ($user == null) {
            return $this->buildErrorResponse("User with phone number " . $data['phoneNumber'] . " not found");
        }

        if ($user->otp != $data['otp']) {
            return $this->buildErrorResponse("Invalid OTP " . $data['otp'] . " provided", [], 400);
        }

        $user->update([
            'mobile_verified_at' => now()
        ]);

        return $this->buildSuccessResponse(null, "Mobile number successfully verified");
    }

    public function generateEmailVerificationCode(EmailVerificationRequest $request): JsonResponse
    {
        $userEmail = $request->email;
        $user = User::query()->firstWhere('email', '=', $userEmail);
        $otp = $this->generateOtp();
        $user->otp = $otp;
        $user->save();

        Notification::send($user, new VerifyUserEmail($user));
        return $this->buildSuccessResponse(null, "Verification code successfully sent to the provided email address");
    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        $email = $request->email;
        $otp = $request->otp;

        $user = User::query()
            ->firstWhere('email', '=', $email)
            ->firstWhere('otp', '=', $otp);
        if (!$user) {
            return $this->buildErrorResponse("Invalid OTP or Email provided ", [], 400);
        }

        $user->update([
            'email_verified_at' => now()
        ]);

        return $this->buildSuccessResponse(null, "Email successfully verified");
    }


    public function generateOneTimePin(OtpGenerationRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->firstWhere('phoneNumber', '=', $data['phoneNumber']);

        if ($user == null) {
            return $this->buildErrorResponse("User with phone number " . $data['phoneNumber'] . " not found for OTP generation");
        }

        $generatedOtp = $this->generateOtp();

        $user->update([
            'otp' => $generatedOtp
        ]);

        $this->sendOtpViaSms($user, $generatedOtp);

        return $this->buildSuccessResponse($generatedOtp, "OTP successfully generated and sent to registered mobile number");
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenName = Str::upper(Str::substr($user->firstName, 0, 1) . Str::substr($user->lastName, 0, 1));
            $roleName = $user->role->name;
            $user->tokens()->delete();

            $success['token'] = $user->createToken(
                $tokenName,
                [$roleName],
                now()->addDay()
            )->plainTextToken;
            $success['tokenName'] = $tokenName;
            $success['userRole'] = $roleName;
            $success['tokenType'] = 'Bearer';

            return $this->buildSuccessResponse($success, 'User login successfully.');
        }
        return $this->buildErrorResponse('Invalid credentials provided.', [], 401);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = Auth::user();
        if (!Hash::check($data['currentPassword'], $user->getAuthPassword())) {
            return $this->buildErrorResponse('Existing password and the provided current password do not match');
        }

        if ($data['currentPassword'] == $data['newPassword']) {
            return $this->buildErrorResponse('New and current password cannot be the same', null, 400);
        }

        $user->password = Hash::make($data['newPassword']);
        $user->save();
        return $this->buildSuccessResponse(null, 'Password changed Successfully');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->firstWhere('otp', '=', $data['otp']);
        $user->update([
            'password' => Hash::make($data['password'])
        ]);
        return $this->buildSuccessResponse(null, 'Password reset was Successful');
    }


    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->buildSuccessResponse(null, 'Logout Successful');
    }


}
