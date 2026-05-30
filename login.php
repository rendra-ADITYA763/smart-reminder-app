<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Smart Reminder — Login</title>
    <meta name="description" content="Login or Register to access Smart Reminder — Your personal habit architect and productivity concierge.">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="tailwind.config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #020617; }
        
        /* Aurora / Mesh gradient on left side */
        .brand-bg {
            background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
            position: relative;
            z-index: 1;
        }
        .brand-bg::before, .brand-bg::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            animation: float-slow 15s ease-in-out infinite;
        }
        .brand-bg::before {
            top: -10%; left: -10%;
            width: 60%; height: 60%;
            background: rgba(37, 99, 235, 0.4); /* blue-600 */
        }
        .brand-bg::after {
            bottom: -10%; right: -10%;
            width: 60%; height: 60%;
            background: rgba(79, 70, 229, 0.3); /* indigo-600 */
            animation-delay: -7s;
        }

        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-30px, 30px) scale(0.9); }
        }

        /* Glass inputs */
        .auth-input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: white !important;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .auth-input:focus {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }

        /* Primary Button */
        .btn-primary {
            background: linear-gradient(to right, #2563eb, #3b82f6);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
            transform: skewX(-20deg);
            transition: 0.5s;
        }
        .btn-primary:hover::after {
            left: 150%;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5);
        }

        /* Feature cards */
        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            transition: all 0.4s;
        }
        .feature-card:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Form animation staggered */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-stagger {
            opacity: 0;
            animation: slideUpFade 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

        /* Floating Input Hover */
        .group-focus-within .auth-input {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2) !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body class="text-white min-h-screen flex overflow-hidden font-sans">

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] px-6 py-3 rounded-2xl text-sm font-semibold shadow-2xl flex items-center gap-3 transition-all duration-300 transform -translate-y-24 opacity-0 border pointer-events-none">
        <span id="toastIcon" class="material-symbols-outlined text-lg"></span>
        <span id="toastMessage"></span>
    </div>

    <!-- Left Side: Branding / Visuals -->
    <div class="hidden lg:flex w-[45%] xl:w-1/2 brand-bg flex-col justify-between p-12 overflow-hidden border-r border-white/5 relative">
        
        <!-- Decorative rings -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full pointer-events-none"></div>
        
        <!-- Logo -->
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <span class="material-symbols-outlined text-white">bolt</span>
            </div>
            <span class="text-xl font-bold text-white tracking-tight">Smart Reminder</span>
        </div>

        <!-- Content -->
        <div class="relative z-10 my-auto pt-12">
            <h1 class="text-5xl xl:text-6xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
                Tingkatkan <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Produktivitas</span> Anda.
            </h1>
            <p class="text-lg text-slate-400 max-w-md mb-12 leading-relaxed">
                Platform pintar untuk mengelola jadwal, melacak kebiasaan, dan mencapai target Anda setiap hari dengan analitik canggih.
            </p>

            <!-- Bento Grid Stats / Features -->
            <div class="grid grid-cols-2 gap-5 max-w-lg">
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center mb-4 border border-blue-500/20">
                        <span class="material-symbols-outlined text-blue-400">task_alt</span>
                    </div>
                    <h3 class="text-white font-bold mb-1.5 text-lg">Manajemen</h3>
                    <p class="text-sm text-slate-400">Kelola semua aktivitas harian di satu tempat terpadu.</p>
                </div>
                <div class="feature-card translate-y-8">
                    <div class="w-12 h-12 rounded-full bg-amber-500/20 flex items-center justify-center mb-4 border border-amber-500/20">
                        <span class="material-symbols-outlined text-amber-400">insights</span>
                    </div>
                    <h3 class="text-white font-bold mb-1.5 text-lg">Analitik Pintar</h3>
                    <p class="text-sm text-slate-400">Pantau performa dan tingkatkan konsistensi Anda.</p>
                </div>
            </div>
        </div>

        <!-- Footer of left side -->
        <div class="relative z-10 flex items-center gap-4 text-sm text-slate-500 font-medium">
            <span>© 2024 Smart Reminder Prediksi</span>
            <span class="w-1 h-1 rounded-full bg-slate-600"></span>
            <span>All rights reserved.</span>
        </div>
    </div>

    <!-- Right Side: Auth Form -->
    <div class="w-full lg:w-[55%] xl:w-1/2 flex items-center justify-center p-6 lg:p-12 h-screen overflow-y-auto bg-[#020617] relative">
        
        <!-- Interactive Canvas Background for Right Side -->
        <canvas id="loginCanvas" class="absolute top-0 left-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        <!-- Ambient glow for right side -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="w-full max-w-[420px] relative z-10">
            
            <!-- Mobile Logo (visible only on mobile) -->
            <div class="flex lg:hidden items-center justify-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-white">bolt</span>
                </div>
                <span class="text-2xl font-bold text-white tracking-tight">Smart Reminder</span>
            </div>

            <div class="mb-8 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                <p class="text-slate-400 text-sm">Silakan masuk atau buat akun baru untuk melanjutkan.</p>
            </div>

            <!-- Segmented Control Tabs -->
            <div class="relative flex p-1.5 bg-white/5 rounded-xl backdrop-blur-sm border border-white/5 w-full mb-8">
                <div id="tabIndicator" class="absolute inset-y-1.5 left-1.5 w-[calc(50%-6px)] bg-white/10 rounded-lg shadow-sm transition-transform duration-300 ease-out border border-white/10"></div>
                <button id="tabLogin" onclick="switchTab('login')" class="relative z-10 w-1/2 py-2.5 text-sm font-semibold text-white transition-colors duration-300">Login</button>
                <button id="tabRegister" onclick="switchTab('register')" class="relative z-10 w-1/2 py-2.5 text-sm font-semibold text-slate-400 transition-colors duration-300">Register</button>
            </div>

            <!-- LOGIN FORM -->
            <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-5 relative z-10">
                <div class="animate-stagger delay-1">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg group-focus-within:text-blue-400 transition-colors z-10">mail</span>
                        <input id="loginEmail" type="email" required placeholder="nama@email.com" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm outline-none relative z-0" />
                    </div>
                </div>
                <div class="animate-stagger delay-2">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg group-focus-within:text-blue-400 transition-colors z-10">lock</span>
                        <input id="loginPassword" type="password" required placeholder="••••••••" class="auth-input w-full pl-12 pr-12 py-3.5 rounded-xl text-sm outline-none relative z-0" />
                        <button type="button" onclick="togglePassword('loginPassword', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-400 transition-colors z-10">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end animate-stagger delay-2">
                    <a href="#" class="text-xs text-blue-400 hover:text-blue-300 font-semibold transition-colors">Lupa Password?</a>
                </div>

                <div class="animate-stagger delay-3">
                    <button id="loginBtn" type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-bold text-sm shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 mt-2">
                        Masuk ke Dashboard
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center gap-4 my-6 animate-stagger delay-4">
                    <div class="h-px bg-white/5 flex-1"></div>
                    <span class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Atau gunakan demo</span>
                    <div class="h-px bg-white/5 flex-1"></div>
                </div>

                <div class="animate-stagger delay-5">
                    <button type="button" onclick="fillDemo('admin@smart-reminder.com','admin123')" class="w-full py-3.5 px-4 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 hover:border-white/20 transition-all flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center border border-amber-500/30 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-amber-400 text-lg">shield_person</span>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold text-white">Akun Admin Demo</p>
                                <p class="text-xs text-slate-400">admin@smart-reminder.com</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-500 group-hover:text-white transition-colors">chevron_right</span>
                    </button>
                </div>
            </form>

            <!-- REGISTER FORM -->
            <form id="registerForm" onsubmit="handleRegister(event)" class="space-y-5 hidden relative z-10">
                <div class="animate-stagger delay-1">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Full Name</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg group-focus-within:text-blue-400 transition-colors z-10">person</span>
                        <input id="regName" type="text" required placeholder="Nama lengkap Anda" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm outline-none relative z-0" />
                    </div>
                </div>
                <div class="animate-stagger delay-2">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg group-focus-within:text-blue-400 transition-colors z-10">mail</span>
                        <input id="regEmail" type="email" required placeholder="nama@email.com" class="auth-input w-full pl-12 pr-4 py-3.5 rounded-xl text-sm outline-none relative z-0" />
                    </div>
                </div>
                <div class="animate-stagger delay-3">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg group-focus-within:text-blue-400 transition-colors z-10">lock</span>
                        <input id="regPassword" type="password" required placeholder="Minimal 6 karakter" minlength="6" class="auth-input w-full pl-12 pr-12 py-3.5 rounded-xl text-sm outline-none relative z-0" />
                        <button type="button" onclick="togglePassword('regPassword', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-400 transition-colors z-10">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Role Selector -->
                <div class="animate-stagger delay-4">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Pilih Role</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="user" class="peer sr-only" onchange="selectRole('user')" checked>
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-center transition-all peer-checked:border-blue-500/50 peer-checked:bg-blue-500/10 peer-hover:bg-white/10">
                                <span class="material-symbols-outlined text-2xl text-blue-400 mb-2 group-hover:scale-110 transition-transform">person</span>
                                <p class="font-bold text-white text-sm">User</p>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">Akses standar</p>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="role" value="admin" class="peer sr-only" onchange="selectRole('admin')">
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-center transition-all peer-checked:border-amber-500/50 peer-checked:bg-amber-500/10 peer-hover:bg-white/10">
                                <span class="material-symbols-outlined text-2xl text-amber-400 mb-2 group-hover:scale-110 transition-transform">shield_person</span>
                                <p class="font-bold text-white text-sm">Admin</p>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">Akses penuh</p>
                            </div>
                        </label>
                    </div>
                    <input type="hidden" id="regRole" value="user" />
                </div>

                <div class="animate-stagger delay-5">
                    <button id="regBtn" type="submit" class="btn-primary w-full py-4 rounded-xl text-white font-bold text-sm shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 mt-4">
                        Buat Akun
                        <span class="material-symbols-outlined text-lg">how_to_reg</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedRole = 'user';

        function switchTab(tab) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const tabLogin = document.getElementById('tabLogin');
            const tabRegister = document.getElementById('tabRegister');
            const indicator = document.getElementById('tabIndicator');

            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                
                tabLogin.classList.replace('text-slate-400', 'text-white');
                tabRegister.classList.replace('text-white', 'text-slate-400');
                
                indicator.style.transform = 'translateX(0)';
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                
                tabRegister.classList.replace('text-slate-400', 'text-white');
                tabLogin.classList.replace('text-white', 'text-slate-400');
                
                indicator.style.transform = 'translateX(100%)';
            }
        }

        function selectRole(role) {
            selectedRole = role;
            document.getElementById('regRole').value = role;
        }

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        function fillDemo(email, password) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = password;
            switchTab('login');
            showToast('Demo credentials filled!', 'info');
        }

        function setLoading(btnId, loading) {
            const btn = document.getElementById(btnId);
            if (loading) {
                btn.disabled = true;
                btn.dataset.original = btn.innerHTML;
                btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-lg">progress_activity</span> Memproses...';
                btn.classList.add('opacity-80', 'cursor-not-allowed');
            } else {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.original;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toastIcon');
            const msg = document.getElementById('toastMessage');

            msg.textContent = message;
            
            toast.className = 'fixed top-6 left-1/2 -translate-x-1/2 z-[100] px-6 py-3 rounded-2xl text-sm font-semibold shadow-2xl flex items-center gap-3 transition-all duration-300 transform -translate-y-24 opacity-0 border';

            if (type === 'success') {
                toast.classList.add('bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-500', 'backdrop-blur-md');
                icon.textContent = 'check_circle';
            } else if (type === 'error') {
                toast.classList.add('bg-red-500/10', 'border-red-500/20', 'text-red-500', 'backdrop-blur-md');
                icon.textContent = 'error';
            } else {
                toast.classList.add('bg-blue-500/10', 'border-blue-500/20', 'text-blue-500', 'backdrop-blur-md');
                icon.textContent = 'info';
            }

            void toast.offsetWidth; // Force reflow

            toast.classList.remove('-translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('-translate-y-24', 'opacity-0');
            }, 3500);
        }

        async function handleLogin(e) {
            e.preventDefault();
            setLoading('loginBtn', true);

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            try {
                const res = await fetch('api/auth.php?action=login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await res.json();

                if (data.success) {
                    showToast(`Selamat datang, ${data.user.name}!`, 'success');
                    setTimeout(() => window.location.href = 'index.php', 1200);
                } else {
                    showToast(data.error, 'error');
                    setLoading('loginBtn', false);
                }
            } catch (err) {
                showToast('Koneksi gagal, coba lagi', 'error');
                setLoading('loginBtn', false);
            }
        }

        async function handleRegister(e) {
            e.preventDefault();
            setLoading('regBtn', true);

            const name = document.getElementById('regName').value;
            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;
            const role = document.getElementById('regRole').value;

            try {
                const res = await fetch('api/auth.php?action=register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password, role })
                });
                const data = await res.json();

                if (data.success) {
                    showToast(`Akun berhasil dibuat! Selamat datang, ${data.user.name}`, 'success');
                    setTimeout(() => window.location.href = 'index.php', 1200);
                } else {
                    showToast(data.error, 'error');
                    setLoading('regBtn', false);
                }
            } catch (err) {
                showToast('Koneksi gagal, coba lagi', 'error');
                setLoading('regBtn', false);
            }
        }

        // --- Interactive Login Canvas (Floating Embers) ---
        const canvas = document.getElementById('loginCanvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let w, h, embers = [];

            function resizeCanvas() {
                w = canvas.width = canvas.parentElement.offsetWidth;
                h = canvas.height = canvas.parentElement.offsetHeight;
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            class Ember {
                constructor() {
                    this.x = Math.random() * w;
                    this.y = h + Math.random() * 200;
                    this.size = Math.random() * 3 + 1;
                    this.speed = Math.random() * 2 + 0.5;
                    this.angle = Math.random() * Math.PI * 2;
                    this.spin = (Math.random() - 0.5) * 0.05;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }
                update() {
                    this.y -= this.speed;
                    this.x += Math.sin(this.angle) * 0.5;
                    this.angle += this.spin;
                    if (this.y < -50) {
                        this.y = h + 50;
                        this.x = Math.random() * w;
                    }
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(96, 165, 250, ${this.opacity})`;
                    ctx.shadowBlur = 15;
                    ctx.shadowColor = '#60a5fa';
                    ctx.fill();
                }
            }
            for (let i = 0; i < 60; i++) embers.push(new Ember());
            
            function animateCanvas() {
                ctx.clearRect(0, 0, w, h);
                embers.forEach(ember => { ember.update(); ember.draw(); });
                requestAnimationFrame(animateCanvas);
            }
            animateCanvas();
        }
    </script>
</body>
</html>
