<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Smart Reminder Prediksi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="tailwind.config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="app.css" />
</head>

<body
    class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col antialiased transition-colors duration-300">
    <!-- TopNavBar -->
    <nav
        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md fixed top-0 w-full z-50 shadow-sm flex justify-between items-center px-8 h-20 max-w-full mx-auto font-sans tracking-tight border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-white">bolt</span>
            </div>
            <div class="text-2xl font-black text-slate-900 dark:text-white ml-2">
                Smart Reminder
            </div>
        </div>
        <div class="hidden md:flex gap-8">
            <a class="nav-link active text-blue-700 dark:text-blue-400 font-semibold border-b-2 border-blue-700 transition-colors active:scale-95 duration-200"
                href="#" onclick="switchView('dashboard')">Dashboard</a>
            <a class="nav-link text-slate-500 dark:text-slate-400 hover:text-slate-900 transition-colors active:scale-95 duration-200"
                href="#" onclick="switchView('logs')">History</a>
            <a class="nav-link text-slate-500 dark:text-slate-400 hover:text-slate-900 transition-colors active:scale-95 duration-200"
                href="#" onclick="switchView('analytics')">Statistics</a>
            <a class="nav-link text-slate-500 dark:text-slate-400 hover:text-slate-900 transition-colors active:scale-95 duration-200"
                href="#" onclick="switchView('settings')">Settings</a>
        </div>
        <div class="flex items-center gap-4">
            <button id="darkModeToggle" onclick="toggleDarkMode()"
                class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                <span class="material-symbols-outlined">dark_mode</span>
            </button>
            <button
                class="bg-primary text-on-primary px-4 py-2 rounded-xl font-medium shadow-[0_12px_32px_rgba(25,28,29,0.04)] bg-gradient-to-br from-primary to-primary-container"
                onclick="showAddModal()">
                Add Habit
            </button>
            <div class="relative group">
                <span
                    class="material-symbols-outlined text-on-surface-variant cursor-pointer p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">notifications</span>
                <div
                    class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-900 shadow-xl rounded-2xl border border-slate-200 dark:border-slate-800 p-4 hidden group-hover:block z-50">
                    <h4 class="font-bold text-sm mb-2">Recent Alerts</h4>
                    <div id="notificationList" class="text-xs space-y-2 text-slate-500">
                        No new notifications
                    </div>
                </div>
            </div>
            <span
                class="material-symbols-outlined text-on-surface-variant cursor-pointer p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">account_circle</span>
        </div>
    </nav>
