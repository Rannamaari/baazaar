<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Verify Email - Baazaar Maldives</title>
    <meta name="description" content="Verify your email address to complete your Baazaar account setup and start shopping.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-blue-50 min-h-screen font-sans">
    <div class="min-h-screen flex items-center justify-center p-8">
        <div class="w-full max-w-lg">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-3 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">B</span>
                    </div>
                    <span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Baazaar</span>
                </div>
                <p class="text-slate-600">Your trusted shopping destination</p>
            </div>
            
            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-800 mb-2">Verify Your Email Address</h1>
                    <p class="text-slate-600">We've sent a verification link to your email address</p>
                </div>
                
                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-sm font-medium text-green-800">
                                A new verification link has been sent to your email address!
                            </p>
                        </div>
                    </div>
                @endif
                
                <!-- Instructions -->
                <div class="bg-slate-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-slate-800 mb-3">Before you continue:</h3>
                    <div class="space-y-3 text-sm text-slate-600">
                        <div class="flex items-start space-x-3">
                            <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mt-0.5">1</span>
                            <p>Check your email inbox for a verification message from Baazaar</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mt-0.5">2</span>
                            <p>Click the verification link in the email to activate your account</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mt-0.5">3</span>
                            <p>Return here and you'll be automatically redirected to your dashboard</p>
                        </div>
                    </div>
                </div>
                
                <!-- Email Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Didn't receive the email?</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Check your spam folder, or click the button below to send another verification email.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="space-y-4">
                    <!-- Resend Button -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            Resend Verification Email
                        </button>
                    </form>
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-slate-600 hover:text-slate-800 py-2 px-4 rounded-xl font-medium transition-colors duration-200">
                            Use a different account
                        </button>
                    </form>
                </div>
                
                <!-- Help -->
                <div class="mt-8 pt-6 border-t border-slate-200 text-center">
                    <p class="text-sm text-slate-500">
                        Need help? Contact our support team at 
                        <a href="mailto:support@baazaar.mv" class="text-blue-600 hover:text-blue-700 font-medium">support@baazaar.mv</a>
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} Baazaar Maldives. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>