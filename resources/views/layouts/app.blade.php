<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Plan Generator')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .step-active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        .step-done {
            background: #10b981;
            color: white;
        }
        .step-inactive {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.4);
        }
        input[type="color"] {
            -webkit-appearance: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            padding: 2px;
        }
        .form-input {
            @apply w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all;
        }
        .form-label {
            @apply block text-white/80 text-sm font-medium mb-2;
        }
        .btn-primary {
            @apply bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl transition-all transform hover:scale-105 shadow-lg;
        }
        .btn-secondary {
            @apply bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-3 rounded-xl transition-all border border-white/20;
        }
        select.form-input option {
            background: #1e293b;
            color: white;
        }
        textarea.form-input {
            resize: vertical;
            min-height: 100px;
        }
        .form-input {
    @apply w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all;
    color-scheme: dark;  /* ← tells browser to use dark native controls */
}

select.form-input option {
    background-color: #1e293b;  /* ← already exists, but make sure it's there */
    color: #ffffff;
}

input.form-input,
textarea.form-input {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}
    </style>
    @stack('styles')
</head>
<body class="gradient-bg min-h-screen text-white">
    @yield('content')
    @stack('scripts')
</body>
</html>
