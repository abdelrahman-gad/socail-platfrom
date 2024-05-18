<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\Auth\LoginRequest;
use App\Http\Requests\Api\Site\Auth\RegisterRequest;
use App\Http\Requests\Api\Site\Auth\VerifyAccountRequest;
use App\Models\Otp;
use App\Models\User;
use App\Repositories\Eloquents\OtpRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Services\TwilioOtpService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {


    protected TwilioOtpService  $twilioOtpService;
    protected UserRepository $userRepository;
    protected OtpRepository $otpRepository;

    public function __construct(
        TwilioOtpService $twilioOtpService,
        UserRepository $userRepository,
        OtpRepository $otpRepository
        ) {
        $this->twilioOtpService = $twilioOtpService;
        $this->userRepository = $userRepository;
        $this->otpRepository = $otpRepository;
    }

    public function login( LoginRequest $request ): JsonResponse {

        $user = $this->userRepository->whereColumns(['mobile'=>$request->mobile])->first();


        if(!$user) return response()->json( [ 'message'=>'User Not Found' ], Response::HTTP_UNAUTHORIZED );

        if(!$user->is_active ) return response()->json( [ 'message'=>'Account is not Activated' ], Response::HTTP_UNAUTHORIZED );

        $credentials = $request->only( [ 'mobile', 'password' ] );

        if (!auth( 'user-api' )->attempt( $credentials ) ) {
            return response()->json( [ 'message'=>'Invalid Credentials' ], JsonResponse::HTTP_UNAUTHORIZED );
        }

        $user = Auth::guard('user-api')->user();
     
        $token =  $user->createToken(config('sanctum.jwt-secret'),['user'])->plainTextToken;

        
        return response()->json( [
            'message' => 'Login Successfully',
            'token' => $token,
            'user' => auth( 'user-api' )->user()
        ], Response::HTTP_OK );
    }

    public function register( RegisterRequest $request ): JsonResponse {

       
        $userReq = [
            'name'=> $request->name,
            'username'=> $request->username,
            'mobile' => $request->mobile,
            'password'=> Hash::make( $request->password ),
        ];

        $user = $this->userRepository->create( $userReq );

        try{
            $otpCode = $this->twilioOtpService->generateOtp();
        }catch(Exception $e){
            Log::error(" Message: ".$e->getMessage()." File: ".$e->getFile()." Line: ".$e->getLine());
        }

        $this->otpRepository->create( [
            'user_id'=> $user->id,
            'code'=> $otpCode,
            'expire_at'=> now()->addMinutes( 5 )
        ] );

      
        return response()->json( [
            'message'=> 'Account Created Successfull. Otp Should be sent to verify account'
        ], Response::HTTP_OK );
        
    }

    public function verifyAccount( VerifyAccountRequest $request ): JsonResponse {

        $otp = $this->otpRepository->where('code',$request->code)
                                    ->where('expire_at','>',now())                     
                                    ->first();
                                  

        if ( !$otp ) {
            return response()->json( [
                'message' => 'Invalid Otp'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }

        $user = $this->userRepository->find( $otp->user_id );

        if ( !$user ) {
            return response()->json( [
                'message' => 'User Not Found'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }
       
        $this->userRepository->update( $user->id  , [
            'mobile_verified_at' => now(),
            'is_active' => true
        ] );

        $otp->delete();

        return response()->json( [
            'message' => 'Account Verified Successfully'
        ], Response::HTTP_OK );

    }


    public function resendOtp( Request $request ): JsonResponse {

        $user = $this->userRepository->whereColumns(['username'=>$request->username])->first();

        if ( !$user ) {
            return response()->json( [
                'message' => 'User Not Found'
            ], Response::HTTP_UNPROCESSABLE_ENTITY );
        }

        $otpCode = $this->twilioOtpService->generateOtp();

        $this->otpRepository->create([
            'user_id'=> $user->id,
            'code'=> $otpCode,
            'expire_at'=> now()->addMinutes( 5 )
        ]);
       

        if ( $this->twilioOtpService->sendOtp( $request->mobile, $otpCode ) ) {
            return response()->json( [
                'message'=> 'Otp Sent Successfully'
            ], Response::HTTP_OK );
        } else {
            return response()->json( [
                'message' => 'Error Sending Otp'
            ], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json( [
            'message' => 'Logout Successfully',
        ], Response::HTTP_OK );
    }


}
