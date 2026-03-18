<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function showRegisterForm()
    {
        return view('register');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['Email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            Auth::user()->update([
                'last_login_at' => now(),
            ]);
            Log::info('User logged in: ' . Auth::user()->Email . ' with role: ' . Auth::user()->role);
            if (Auth::user()->role === 'admin') {
                Log::info('Redirecting to /admin');
                return redirect('/admin')->with('success', 'Welcome to the Admin Dashboard!');
            }
            Log::info('Redirecting to /');
            return redirect('/')->with('success', 'Welcome back!');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->withInput();
    }
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:Customer,Email',
            'password' => 'required|min:6|confirmed', 
        ]);
        Customer::create([
            'Email' => $request->email,
            'Password' => $request->password,
        ]);
        return redirect()->route('registration_success')->with('success', 'Account created! Please login.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
