<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Reminder — Habit Architect & Productivity Concierge</title>
    <meta name="description" content="Tingkatkan produktivitas Anda dengan Smart Reminder, platform manajemen tugas dan pelacak kebiasaan pintar yang dilengkapi AI Assistant.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #020617; color: white; overflow-x: hidden; margin: 0; }
        
        /* Interactive Canvas */
        #particleCanvas {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100vh;
            z-index: -20;
            pointer-events: none;
        }

        /* Animated Background Mesh - Kept subtle */
        .mesh-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100vh;
            overflow: hidden;
            z-index: -30;
            pointer-events: none;
        }
        .mesh-blob {
            position: absolute;
            filter: blur(150px);
            border-radius: 50%;
            animation: float 25s ease-in-out infinite;
            opacity: 0.4;
        }
        .blob-1 { top: -10%; left: -10%; width: 60%; height: 60%; background: #2563eb; }
        .blob-2 { bottom: -10%; right: -10%; width: 60%; height: 60%; background: #8b5cf6; animation-delay: -5s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.1); }
            66% { transform: translate(-50px, 50px) scale(0.9); }
        }

        /* Glassmorphism Components */
        .glass-nav {
            background: rgba(2, 6, 23, 0.5);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        /* 3D Tilt Card Base */
        .tilt-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            transform-style: preserve-3d;
            transform: perspective(1000px);
            transition: border-color 0.3s ease;
        }
        .tilt-card:hover {
            border-color: rgba(96, 165, 250, 0.5);
        }
        .tilt-content {
            transform: translateZ(40px); /* Pops content out */
        }

        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shine 4s linear infinite;
        }
        @keyframes shine {
            to { background-position: 200% center; }
        }

        /* Primary Button */
        .btn-primary {
            background: linear-gradient(to right, #2563eb, #8b5cf6);
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            z-index: 1;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to right, #3b82f6, #a855f7);
            z-index: -1;
            transition: opacity 0.3s;
            opacity: 0;
        }
        .btn-primary:hover::before { opacity: 1; }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 15px 30px -10px rgba(139, 92, 246, 0.6);
        }

        /* Feature Icons */
        .feature-icon-wrapper {
            width: 4rem; height: 4rem;
            border-radius: 1.2rem;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.2), rgba(168, 85, 247, 0.2));
            border: 1px solid rgba(96, 165, 250, 0.3);
            color: #93c5fd;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 20px rgba(96, 165, 250, 0.1) inset;
        }

        /* Typewriter Cursor */
        .cursor {
            display: inline-block;
            width: 4px;
            background-color: #60a5fa;
            animation: blink 1s step-end infinite;
        }
        @keyframes blink { 50% { opacity: 0; } }
    </style>
</head>
<body class="antialiased selection:bg-blue-500/30">

    <!-- Backgrounds -->
    <canvas id="particleCanvas"></canvas>
    <div class="mesh-bg">
        <div class="mesh-blob blob-1"></div>
        <div class="mesh-blob blob-2"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300 py-4">
        <div class="container mx-auto px-6 lg:px-12 flex items-center justify-between">
            <div class="flex items-center gap-3 hover:scale-105 transition-transform cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-lg shadow-blue-500/30 border border-white/10">
                    <span class="material-symbols-outlined text-white">bolt</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">Smart Reminder</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hover:scale-110">Fitur</a>
                <a href="login.php" class="text-sm font-semibold text-white px-5 py-2.5 rounded-lg border border-white/10 hover:bg-white/10 transition-colors">Login</a>
                <a href="login.php" class="btn-primary text-sm font-bold text-white px-6 py-2.5 rounded-lg shadow-lg shadow-blue-500/25">Mulai Sekarang</a>
            </div>
            <div class="md:hidden">
                <a href="login.php" class="btn-primary text-sm font-bold text-white px-5 py-2.5 rounded-lg shadow-lg shadow-blue-500/25">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-56 lg:pb-40 flex items-center justify-center min-h-screen text-center px-6" style="perspective: 1000px;">
        <div class="max-w-4xl mx-auto z-10 hero-content transition-transform duration-700 ease-out" id="heroCard">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full tilt-card mb-10 border-blue-500/30 bg-blue-500/10 text-blue-300 text-xs font-semibold uppercase tracking-widest cursor-default">
                <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                Rilis Interaktif v1.3
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tight leading-[1.1] mb-8 select-none">
                Bangun Kebiasaan <br class="hidden md:block" />
                <span class="text-gradient" id="typewriterText"></span><span class="cursor">&nbsp;</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed font-medium">
                Gerakkan kursor Anda untuk melihat keajaiban. Smart Reminder bukan sekadar alarm, ini adalah asisten visual yang akan membuat Anda <span class="text-purple-400 font-semibold tracking-wide">ketagihan produktif</span>.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="login.php" class="btn-primary w-full sm:w-auto px-10 py-5 rounded-2xl font-black text-lg flex items-center justify-center gap-3">
                    Mulai Perjalanan Anda
                    <span class="material-symbols-outlined">rocket_launch</span>
                </a>
                <a href="#fitur" class="w-full sm:w-auto px-10 py-5 rounded-2xl font-bold text-lg text-white border border-white/20 bg-white/5 hover:bg-white/10 transition-colors backdrop-blur-md flex items-center justify-center">
                    Eksplorasi Fitur
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce flex flex-col items-center text-slate-500 pointer-events-none">
            <span class="text-xs font-bold tracking-widest uppercase mb-2">Scroll</span>
            <span class="material-symbols-outlined">arrow_downward</span>
        </div>
    </section>

    <!-- Features Section with 3D Tilt Cards -->
    <section id="fitur" class="py-32 relative z-10 border-t border-white/5 bg-[#020617]/50 backdrop-blur-md">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="text-center max-w-3xl mx-auto mb-24">
                <h2 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">Fitur <span class="text-gradient">Unggulan</span></h2>
                <p class="text-slate-400 text-xl font-medium">Arahkan kursor Anda ke kartu di bawah ini untuk melihat efek 3D interaktif.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                
                <!-- Feature Cards -->
                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">task_alt</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Habit Tracker</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Pantau rutinitas dengan visualisasi cantik. Centang aktivitas dan bangun *streak* kebiasaan positif Anda.
                        </p>
                    </div>
                </div>

                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">insights</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Analitik Pintar</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Wawasan mendalam mengenai performa Anda melalui grafik visual yang mempesona dan akurat.
                        </p>
                    </div>
                </div>

                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">smart_toy</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Asisten AI Gemini</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Tanya apa saja ke AI cerdas bawaan yang siap memberi saran kesehatan dan jadwal secara *real-time*.
                        </p>
                    </div>
                </div>

                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">cloud</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Cuaca Live</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Prakiraan cuaca super interaktif untuk merencanakan aktivitas luar ruangan dengan sempurna.
                        </p>
                    </div>
                </div>

                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">event_upcoming</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Manajemen Jadwal</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Kalender interaktif untuk mengatur jadwal meeting, kelas, dan event tanpa pernah terlewat.
                        </p>
                    </div>
                </div>

                <div class="tilt-card p-10 cursor-pointer group">
                    <div class="tilt-content">
                        <div class="feature-icon-wrapper group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-4xl">shield_person</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-white">Role Access</h3>
                        <p class="text-slate-400 leading-relaxed text-base">
                            Sistem keamanan multi-role (User & Admin) untuk manajemen data yang aman dan terstruktur.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-[#020617]/90 backdrop-blur-xl py-12 relative z-10">
        <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">bolt</span>
                <span class="font-bold text-white tracking-tight">Smart Reminder</span>
            </div>
            <p class="text-slate-500 text-sm text-center">
                © 2024 Smart Reminder Prediksi. All rights reserved. <br class="md:hidden" />
                Designed with ♥ for productivity.
            </p>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // 1. Typewriter Effect
        const textToType = "Lebih Cerdas & Konsisten.";
        const typeTarget = document.getElementById("typewriterText");
        let typeIndex = 0;
        
        function typeWriter() {
            if (typeIndex < textToType.length) {
                typeTarget.innerHTML += textToType.charAt(typeIndex);
                typeIndex++;
                setTimeout(typeWriter, 100);
            }
        }
        setTimeout(typeWriter, 500);

        // 2. 3D Tilt Effect on Cards
        const tiltCards = document.querySelectorAll('.tilt-card');
        tiltCards.forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -15; // Max 15 deg tilt
                const rotateY = ((x - centerX) / centerX) * 15;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)`;
                card.style.transition = 'transform 0.5s ease';
            });
            
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'none'; // Remove transition for smooth tracking
            });
        });

        // 3. Hero Card subtle parallax
        const heroCard = document.getElementById('heroCard');
        document.addEventListener('mousemove', e => {
            const x = (window.innerWidth / 2 - e.pageX) / 50;
            const y = (window.innerHeight / 2 - e.pageY) / 50;
            heroCard.style.transform = `translate(${x}px, ${y}px)`;
        });

        // 4. Interactive Canvas Particle Network
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];
        const mouse = { x: null, y: null, radius: 150 };

        window.addEventListener('resize', resizeCanvas);
        function resizeCanvas() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        resizeCanvas();

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.x;
            mouse.y = e.y;
        });

        window.addEventListener('mouseout', () => {
            mouse.x = null;
            mouse.y = null;
        });

        class Particle {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 2 + 1;
                this.baseX = this.x;
                this.baseY = this.y;
                this.density = (Math.random() * 30) + 1;
                this.vx = (Math.random() - 0.5) * 1;
                this.vy = (Math.random() - 0.5) * 1;
            }
            draw() {
                ctx.fillStyle = 'rgba(147, 197, 253, 0.8)'; // blue-300
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
            }
            update() {
                // Constant slow movement
                this.x += this.vx;
                this.y += this.vy;

                // Bounce off edges
                if(this.x < 0 || this.x > width) this.vx *= -1;
                if(this.y < 0 || this.y > height) this.vy *= -1;

                // Mouse interaction (repel & draw lines)
                if (mouse.x != null && mouse.y != null) {
                    let dx = mouse.x - this.x;
                    let dy = mouse.y - this.y;
                    let distance = Math.sqrt(dx * dx + dy * dy);
                    let forceDirectionX = dx / distance;
                    let forceDirectionY = dy / distance;
                    let maxDistance = mouse.radius;
                    let force = (maxDistance - distance) / maxDistance;
                    let directionX = forceDirectionX * force * this.density;
                    let directionY = forceDirectionY * force * this.density;

                    if (distance < mouse.radius) {
                        this.x -= directionX;
                        this.y -= directionY;
                    }
                }
            }
        }

        function initParticles() {
            particles = [];
            let numberOfParticles = (width * height) / 10000;
            if (numberOfParticles > 200) numberOfParticles = 200; // Cap limit
            for (let i = 0; i < numberOfParticles; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, width, height);
            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();
                
                // Connect particles
                for (let j = i; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;
                    let distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < 120) {
                        ctx.beginPath();
                        ctx.strokeStyle = `rgba(147, 197, 253, ${1 - distance/120})`;
                        ctx.lineWidth = 1;
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                        ctx.closePath();
                    }
                }
                
                // Connect to mouse
                if (mouse.x != null) {
                    let dx = particles[i].x - mouse.x;
                    let dy = particles[i].y - mouse.y;
                    let distance = Math.sqrt(dx * dx + dy * dy);
                    if (distance < mouse.radius) {
                        ctx.beginPath();
                        ctx.strokeStyle = `rgba(168, 85, 247, ${1 - distance/mouse.radius})`; // purple tint
                        ctx.lineWidth = 1.5;
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.stroke();
                        ctx.closePath();
                    }
                }
            }
            requestAnimationFrame(animateParticles);
        }

        initParticles();
        animateParticles();
    </script>
</body>
</html>
