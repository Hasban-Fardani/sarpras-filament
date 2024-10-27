import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/login.blade.php',
        './resources/views/reset-password.blade.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
  theme: {
    extend: {},
  },
  plugins: [],
}

