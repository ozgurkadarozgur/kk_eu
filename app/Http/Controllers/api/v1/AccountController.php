<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\OAuthHelper;
use App\Helpers\VatanSMS;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Account\ForgotPasswordRequest;
use App\Http\Requests\Api\Account\ResetPasswordRequest;
use App\Http\Requests\Api\Account\SignInRequest;
use App\Http\Requests\Api\Account\SignUpRequest;
use App\Http\Requests\Api\Account\SignUpValidate1;
use App\Http\Requests\Api\Account\SignUpValidate2;
use App\Http\Requests\Api\Account\VerifyPhoneRequest;
use App\Jobs\SendSMSJob;
use App\Repositories\Interfaces\IPlayerPasswordResetRepository;
use App\Repositories\Interfaces\IPlayerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    private $playerRepository;
    private $playerPasswordResetRepository;

    public function __construct(IPlayerRepository $playerRepository, IPlayerPasswordResetRepository $playerPasswordResetRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->playerPasswordResetRepository = $playerPasswordResetRepository;
    }

    public function sign_in(SignInRequest $request)
    {
        $validated = $request->validated();
        $access_token = OAuthHelper::get_access_token($validated['email'], $validated['password']);
        if ($access_token) {
            $player = $this->playerRepository->findByEmail($validated['email']);
            if (!$player->phone_confirmed) {
                $code = $code = rand(100000, 999999);;
                $player->phone_code = $code;
                $player->save();
                $message = 'KAFAKAFAYA SMS KODU '. $code . '.';
                SendSMSJob::dispatch($player->phone, $message);
            }
            return response()->json([
                'status' => 'success',
                'data' => [
                    'access_token' => $access_token,
                    'phone_confirmed' => $player->phone_confirmed,
                ],
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Bilgilerinizi kontrol ederek tekrar giriş yapın.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function sign_up(SignUpRequest $request)
    {
        $validated = $request->validated();
        $player = $this->playerRepository->create($validated);
        if ($player) {
            return response()->json([
                'status' => 'success'
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'status'=> 'error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sign_up_validate_1(SignUpValidate1 $request)
    {
        $validated = $request->validated();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function sign_up_validate_2(SignUpValidate2 $request)
    {
        $validated = $request->validated();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function verify_phone(VerifyPhoneRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();
        if ($user->phone_code == $validated['code']) {
            $user->phone_confirmed = true;
            $user->save();
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Hatalı kod girdiniz.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function forgot_password(ForgotPasswordRequest $request)
    {
        $validated = $request->validated();
        $email = $validated['email'];
        $token = Str::random(30);
        $result = $this->playerPasswordResetRepository->createResetPasswordToken($email, $token);
        if ($result) {
            $player = $this->playerRepository->findByEmail($email);
            $url = route('api.player.reset_password_view', $token);
            $message = 'Şifrenizi değiştirmek için tıklayın '. $url;
            SendSMSJob::dispatch($player->phone, $message);
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Bir hata oluştu lütfen daha sonra deneyin.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
