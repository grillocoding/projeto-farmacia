<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email ou senha incorretos.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        // 🔐 2FA
        if ($user->two_factor_enabled) {

            // ⚠️ verifica telefone
            if (!$user->phone) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Cadastre um telefone para usar 2FA.'
                ]);
            }

            // gera código
            $user->generateTwoFactorCode();

            // 🔥 LOG PRA TESTE (IMPORTANTE)
            \Log::info('2FA CODE: ' . $user->two_factor_code);

            // tenta enviar
            try {
                $this->sendSms($user->phone, "Seu código de verificação é: {$user->two_factor_code}");
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar 2FA: ' . $e->getMessage());
            }

            Auth::logout();
            session(['2fa_user_id' => $user->id]);

            return redirect()->route('2fa.verify');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('medicamentos.index'));
    }

    private function sendSms(string $phone, string $message): void
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }

        $apiKey = env('CALLMEBOT_APIKEY');

        if (!$apiKey) {
            throw new \Exception('API KEY não configurada');
        }

        $message = urlencode($message);

        $url = "https://api.callmebot.com/whatsapp.php?phone={$phone}&text={$message}&apikey={$apiKey}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function showVerify()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::find(session('2fa_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->two_factor_code !== $request->code) {
            return back()->withErrors(['code' => 'Código inválido.']);
        }

        if (now()->isAfter($user->two_factor_expires_at)) {
            return back()->withErrors(['code' => 'Código expirado.']);
        }

        $user->resetTwoFactorCode();

        Auth::login($user);
        session()->forget('2fa_user_id');

        $request->session()->regenerate();

        return redirect()->route('medicamentos.index');
    }

    public function toggleTwoFactor()
    {
        $user = Auth::user();

        if ($user->two_factor_enabled) {
            $user->update(['two_factor_enabled' => false]);
            return back()->with('success', '2FA desativado com sucesso!');
        }

        if (!$user->phone) {
            return back()->with('error', 'Cadastre um telefone antes de ativar o 2FA.');
        }

        $user->update(['two_factor_enabled' => true]);

        return back()->with('success', '2FA ativado com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'cpf'         => 'nullable|string|size:14|unique:users,cpf',
            'phone'       => 'nullable|string|max:20',
            'cep'         => 'nullable|string|max:9',
            'address'     => 'nullable|string|max:255',
            'numero'      => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro'      => 'nullable|string|max:100',
            'cidade'      => 'nullable|string|max:100',
            'estado'      => 'nullable|string|size:2',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'cliente';

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('medicamentos.index');
    }
}