<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div class="max-w-md w-full bg-[#fff] rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold mb-4">Reset Password</h1>
        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3 mb-4 md:mb-0">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" class="block w-full p-2 text-sm text-gray-700 rounded-lg border border-gray-300 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3 mb-4 md:mb-0">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password:</label>
                    <input type="password" name="password" id="password" required class="block w-full p-2 text-sm text-gray-700 rounded-lg border border-gray-300 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3 mb-4 md:mb-0">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full p-2 text-sm text-gray-700 rounded-lg border border-gray-300 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Reset Password</button>
        </form>
    </div>
</body>
</html>