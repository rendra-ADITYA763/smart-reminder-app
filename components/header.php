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
    <style>
        /* Premium Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* slate-300 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* slate-400 */
        }
        
        /* Dark mode scrollbar */
        html.dark ::-webkit-scrollbar-track,
        .dark ::-webkit-scrollbar-track {
            background: #0f172a; /* slate-900 */
        }
        html.dark ::-webkit-scrollbar-thumb,
        .dark ::-webkit-scrollbar-thumb {
            background: #334155; /* slate-700 */
        }
        html.dark ::-webkit-scrollbar-thumb:hover,
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #475569; /* slate-600 */
        }
    </style>
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
            <!-- User Profile Dropdown -->
            <div class="relative group">
                <div class="flex items-center gap-2 cursor-pointer p-1.5 pl-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <?php if (isset($sessionUser)): ?>
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-200 leading-tight"><?php echo htmlspecialchars($sessionUser['name']); ?></p>
                        <span class="text-[10px] font-bold uppercase tracking-wider <?php echo $sessionUser['role'] === 'admin' ? 'text-amber-500' : 'text-blue-500'; ?>">
                            <?php echo $sessionUser['role']; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center <?php echo isset($sessionUser) && $sessionUser['role'] === 'admin' ? 'bg-gradient-to-br from-amber-400 to-amber-600' : 'bg-gradient-to-br from-blue-400 to-blue-600'; ?> text-white shadow-sm">
                        <span class="material-symbols-outlined text-lg"><?php echo isset($sessionUser) && $sessionUser['role'] === 'admin' ? 'shield_person' : 'person'; ?></span>
                    </div>
                </div>
                <!-- Dropdown -->
                <div class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-900 shadow-xl rounded-2xl border border-slate-200 dark:border-slate-800 p-3 hidden group-hover:block z-50">
                    <?php if (isset($sessionUser)): ?>
                    <div class="p-3 mb-2 bg-slate-50 dark:bg-slate-800 rounded-xl">
                        <p class="font-bold text-sm dark:text-white"><?php echo htmlspecialchars($sessionUser['name']); ?></p>
                        <p class="text-[10px] text-slate-400 mt-0.5"><?php echo htmlspecialchars($sessionUser['email']); ?></p>
                        <span class="inline-flex items-center gap-1 mt-2 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo $sessionUser['role'] === 'admin' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'; ?>">
                            <span class="material-symbols-outlined text-xs"><?php echo $sessionUser['role'] === 'admin' ? 'shield_person' : 'person'; ?></span>
                            <?php echo $sessionUser['role']; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <a href="#" onclick="switchView('settings')" class="flex items-center gap-3 p-3 rounded-xl text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-lg">settings</span>
                        Settings
                    </a>
                    <button onclick="handleLogout()" class="w-full flex items-center gap-3 p-3 rounded-xl text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors mt-1">
                        <span class="material-symbols-outlined text-lg">logout</span>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

