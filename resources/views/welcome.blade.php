<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wasselm3ak | Marketplace de Transport & Livraison</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        
    </script>
    <style>
       
    </style>
</head>
<body class="bg-sand text-gray-800 font-sans antialiased">
<nav class="fixed w-full z-50 transition-all duration-300 bg-slate-950/80 backdrop-blur-md border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-['Playfair_Display'] italic font-black text-white">Wassel</span>
                <span class="text-2xl font-black text-red-600">M3ak</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#" class="hover:text-white transition-colors">Expéditeurs</a>
                <a href="#" class="hover:text-white transition-colors">Transporteurs</a>
                <a href="#" class="hover:text-white transition-colors">Solutions</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="text-white font-bold px-6 py-2 rounded-lg hover:bg-white/5 transition-all">Connexion</a>
                <a href="#" class="bg-red-600 text-white font-bold px-6 py-2 rounded-lg shadow-lg shadow-red-900/20 hover:bg-red-700 transition-all">Inscription</a>
            </div>
        </div>
    </div>
</nav>
<section class="relative min-h-screen pt-20 flex items-center bg-slate-950 overflow-hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-red-600/5 blur-[120px] rounded-full"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <h1 class="text-6xl lg:text-7xl font-black text-white leading-tight tracking-tighter">
                    L'avenir du <span class="font-['Playfair_Display'] italic italic text-red-500">fret</span> <br> est ici.
                </h1>
                <p class="text-xl text-slate-400 max-w-lg leading-relaxed font-light">
                    WasselM3ak transforme la logistique marocaine en connectant intelligemment les expéditeurs et les transporteurs grâce à une technologie de pointe.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="bg-white text-slate-950 px-8 py-4 rounded-xl font-bold text-lg hover:bg-slate-200 transition-all">
                        Je souhaite expédier
                    </button>
                    <button class="border border-white/20 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/5 transition-all">
                        Je suis transporteur
                    </button>
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/hero-composition.png') }}" class="w-full animate-float drop-shadow-2xl" alt="Digital Logistics">
            </div>
        </div>
    </div>
</section>
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12">
            <div class="group p-10 bg-slate-50 rounded-3xl border border-slate-100 hover:border-red-500/20 transition-all cursor-pointer">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mb-6">
                    <i data-lucide="package" class="text-white w-8 h-8"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-950 mb-4">Pour les expéditeurs</h3>
                <p class="text-slate-600 mb-8 leading-relaxed">Accédez à un vaste réseau de transporteurs fiables et suivez vos marchandises en temps réel avec une précision totale.</p>
                <a href="#" class="text-red-600 font-bold flex items-center gap-2 group-hover:gap-4 transition-all">
                    En savoir plus <i data-lucide="arrow-right"></i>
                </a>
            </div>

            <div class="group p-10 bg-slate-950 rounded-3xl border border-white/5 hover:border-red-500/20 transition-all cursor-pointer">
                <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-red-900/20">
                    <i data-lucide="truck" class="text-white w-8 h-8"></i>
                </div>
                <h3 class="text-3xl font-black text-white mb-4">Pour les transporteurs</h3>
                <p class="text-slate-400 mb-8 leading-relaxed">Optimisez vos trajets, réduisez les kilomètres à vide et faites croître votre entreprise avec des paiements rapides.</p>
                <a href="#" class="text-red-500 font-bold flex items-center gap-2 group-hover:gap-4 transition-all">
                    Rejoindre le réseau <i data-lucide="arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="py-20 bg-slate-950 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
            <div>
                <p class="text-5xl font-['Playfair_Display'] italic font-black text-white mb-2">10K+</p>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Partenaires</p>
            </div>
            <div>
                <p class="text-5xl font-['Playfair_Display'] italic font-black text-white mb-2">50M</p>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">KM Parcourus</p>
            </div>
            <div>
                <p class="text-5xl font-['Playfair_Display'] italic font-black text-white mb-2">24/7</p>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Support Live</p>
            </div>
            <div>
                <p class="text-5xl font-['Playfair_Display'] italic font-black text-white mb-2">99%</p>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Satisfaction</p>
            </div>
        </div>
    </div>
</section>
<footer class="bg-slate-950 pt-20 pb-10 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 md:col-span-1">
                <span class="text-2xl font-['Playfair_Display'] italic font-black text-white">Wassel</span>
                <span class="text-2xl font-black text-red-600">M3ak</span>
                <p class="mt-4 text-slate-500 text-sm">Révolutionner la logistique au Maroc par l'innovation et la confiance.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Plateforme</h4>
                <ul class="text-slate-500 space-y-4 text-sm">
                    <li><a href="#" class="hover:text-red-500 transition-colors">Expéditeurs</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors">Transporteurs</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors">Tarification</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Entreprise</h4>
                <ul class="text-slate-500 space-y-4 text-sm">
                    <li><a href="#" class="hover:text-red-500 transition-colors">À propos</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Légal</h4>
                <ul class="text-slate-500 space-y-4 text-sm">
                    <li><a href="#" class="hover:text-red-500 transition-colors">Confidentialité</a></li>
                    <li><a href="#" class="hover:text-red-500 transition-colors">Conditions d'utilisation</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-white/5 text-center text-slate-600 text-xs tracking-widest uppercase font-bold">
            © 2026 WasselM3ak. Tous droits réservés.
        </div>
    </div>
</footer>
  
</body>
</html>