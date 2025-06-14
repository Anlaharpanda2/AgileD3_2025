<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PasswordOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ResetPasswordController extends Controller
{
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $exists = User::where('email', $request->email)->exists();
        if ($exists) {
            return response()->json(['exists' => true, 'message' => 'Email ditemukan']);
        } else {
            return response()->json(['exists' => false, 'message' => 'Email tidak ditemukan'], 404);
        }
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $otp = rand(100000, 999999);
        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );
        Mail::raw("Kode OTP reset password Anda: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Reset Password');
        });
        return response()->json([
            'message' => 'Kode OTP telah dikirim ke email Anda',
            'email' => $request->email
        ]);
    }
    public function confirmOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);
        $otpData = PasswordOtp::where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
        if (!$otpData) {
            return response()->json(['message' => 'Kode OTP salah atau sudah kadaluarsa'], 422);
        }
        return response()->json([
            'message' => 'Kode OTP valid',
            'email' => $otpData->email,
        ]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        $otpData = PasswordOtp::where('email', $request->email)
            ->where('expires_at', '>', now())
            ->first();
        if (!$otpData) {
            return response()->json(['message' => 'OTP tidak ditemukan atau sudah kadaluarsa untuk email ini'], 422);
        }
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        $otpData->delete();
        return response()->json(['message' => 'Password berhasil direset']);
    }
}