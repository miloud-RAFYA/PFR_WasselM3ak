@extends('layouts.app')

@section('title', 'WasselM3ak - Marketplace logistique')

@section('content')
    <section id="hero" class="relative overflow-hidden bg-slate-950 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.15),_transparent_35%)]"></div>
        <div class="absolute -right-32 top-24 w-72 h-72 rounded-full bg-primary-500/20 blur-3xl"></div>
        <div class="absolute left-0 bottom-0 w-full h-52 bg-gradient-to-t from-slate-950 via-slate-950/90 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200">
                        <span class="inline-flex h-2 w-2 rounded-full bg-primary-400"></span>
                        Marketplace marocain de fret & transport
                    </div>

                    <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-white">
                        Comparez les transporteurs, <br>
                        expédiez partout au Maroc.
                    </h1>

                    <p class="max-w-2xl text-lg leading-8 text-slate-300">
                        Plateforme de mise en relation pour expéditeurs et transporteurs. Recevez plusieurs offres,
                        suivez vos marchandises et payez en toute sérénité.
                    </p>

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-[1fr_auto]">
                        <a href="#quotes" class="inline-flex items-center justify-center rounded-full bg-primary-500 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-primary-500/30 transition hover:bg-primary-400">
                            Obtenir des offres
                        </a>
                        <a href="#how-it-works" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-8 py-4 text-base font-semibold text-white transition hover:bg-white/10">
                            Comment ça marche
                        </a>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-3xl bg-white/5 p-5">
                            <p class="text-3xl font-bold">12K+</p>
                            <p class="mt-2 text-sm text-slate-300">Demandes publiées</p>
                        </div>
                        <div class="rounded-3xl bg-white/5 p-5">
                            <p class="text-3xl font-bold">98%</p>
                            <p class="mt-2 text-sm text-slate-300">Satisfaction client</p>
                        </div>
                        <div class="rounded-3xl bg-white/5 p-5">
                            <p class="text-3xl font-bold">24/7</p>
                            <p class="mt-2 text-sm text-slate-300">Support disponible</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">
                        <div class="grid gap-4">
                            <div class="rounded-3xl bg-slate-950 p-6 border border-white/10">
                                <p class="text-sm uppercase tracking-[0.24em] text-primary-400">Rapide</p>
                                <h2 class="mt-4 text-2xl font-semibold text-white">Demandez un devis instantané</h2>
                                <p class="mt-2 text-sm text-slate-400">Indiquez votre origine, destination et type de marchandise.</p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
                                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Origine</p>
                                    <p class="mt-3 font-semibold text-white">Casablanca</p>
                                </div>
                                <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
                                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Destination</p>
                                    <p class="mt-3 font-semibold text-white">Rabat</p>
                                </div>
                            </div>

                            <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
                                <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Type de transport</p>
                                <p class="mt-3 font-semibold text-white">Camion 7,5T / Palette</p>
                            </div>

                            <div class="rounded-3xl bg-primary-500 p-5 text-white">
                                <p class="font-semibold">Offre proposée</p>
                                <p class="mt-2 text-3xl font-bold">2 400 MAD</p>
                                <p class="mt-1 text-sm text-white/80">Livraison Casablanca → Marrakech, 48h</p>
                            </div>
                        </div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1542196432-f1905c17f6d9?w=900&h=700&fit=crop" alt="Transport" class="mt-8 w-full rounded-[2rem] object-cover shadow-2xl shadow-black/20" />
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-[0.32em] text-primary-500">Comment ça marche</p>
                <h2 class="mt-4 text-4xl font-bold text-slate-900">Un processus simple pour expéditeurs et transporteurs</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-600">Publiez votre demande, comparez les offres et suivez votre chargement du départ à l'arrivée.</p>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">1</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Publiez votre demande</h3>
                    <p class="mt-4 text-slate-600">Ajoutez les détails du trajet, dimensions et urgences pour recevoir rapidement des offres.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">2</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Comparez les transporteurs</h3>
                    <p class="mt-4 text-slate-600">Visualisez les propositions des chauffeurs, évaluations, prix et temps de trajet.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">3</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Choisissez & suivez</h3>
                    <p class="mt-4 text-slate-600">Confirmez un transporteur, payez en ligne et suivez l'avancement en temps réel.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features-client" class="bg-slate-950 text-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 items-center">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-[0.3em] text-primary-400">Pour les expéditeurs</span>
                    <h2 class="mt-4 text-4xl font-bold">Une expérience sur mesure pour vos envois</h2>
                    <p class="mt-6 text-lg text-slate-300">Accédez à un réseau de transporteurs vérifiés, recevez des offres compétitives et suivez chaque étape de la livraison.</p>
                    <div class="mt-10 grid gap-6 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-900/90 p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white">Offres transparentes</h3>
                            <p class="mt-3 text-slate-400">Aucun frais caché et comparaison simple entre transporteurs.</p>
                        </div>
                        <div class="rounded-3xl bg-slate-900/90 p-6 border border-white/10">
                            <h3 class="text-xl font-semibold text-white">Suivi temps réel</h3>
                            <p class="mt-3 text-slate-400">Recevez des mises à jour de localisation jusqu'à la livraison finale.</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-[2rem] overflow-hidden border border-white/10 bg-slate-800/80 shadow-2xl shadow-black/20">
                    <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=900&h=700&fit=crop" alt="Shipment" class="h-full w-full object-cover" />
                </div>
            </div>
        </div>
    </section>

    <section id="features-driver" class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold uppercase tracking-[0.32em] text-primary-500">Pour les transporteurs</span>
                <h2 class="mt-4 text-4xl font-bold text-slate-900">Remplissez vos trajets et gagnez plus</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-600">Choisissez les meilleures missions, réduisez les kilomètres à vide et recevez des paiements rapides.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">+</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Trajets optimisés</h3>
                    <p class="mt-4 text-slate-600">Recevez des demandes correspondant à votre zone et votre type de camion.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">$</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Paiement sécurisé</h3>
                    <p class="mt-4 text-slate-600">Bénéficiez d'un règlement rapide et d'un encaissement garanti pour chaque course.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 p-8 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-500 text-white text-xl font-bold">★</div>
                    <h3 class="mt-6 text-2xl font-semibold text-slate-900">Visibilité accrue</h3>
                    <p class="mt-4 text-slate-600">Augmentez vos réservations grâce à des évaluations et un profil professionnel.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="quotes" class="bg-slate-950 text-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-2 items-center">
                <div class="space-y-6">
                    <span class="inline-flex rounded-full bg-primary-500/10 px-4 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-primary-200">Ce que disent nos clients</span>
                    <h2 class="text-4xl font-bold">Des entreprises qui nous font confiance</h2>
                    <p class="max-w-xl text-slate-400">Des expéditeurs et des transporteurs utilisent WasselM3ak pour sécuriser leurs trajets, réduire les coûts et gagner du temps.</p>
                </div>
                <div class="grid gap-6">
                    <div class="rounded-3xl bg-slate-900/90 p-8 border border-white/10 shadow-lg">
                        <div class="flex items-center gap-4">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop" class="h-14 w-14 rounded-full object-cover" alt="customer">
                            <div>
                                <p class="font-semibold text-white">Sofia B.</p>
                                <p class="text-sm text-slate-400">Expéditrice</p>
                            </div>
                        </div>
                        <p class="mt-6 text-slate-300">« J'ai trouvé un transporteur fiable en moins de 10 minutes. Le suivi et le paiement sécurisé m'ont vraiment rassurée. »</p>
                    </div>
                    <div class="rounded-3xl bg-slate-900/90 p-8 border border-white/10 shadow-lg">
                        <div class="flex items-center gap-4">
                            <img src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?w=100&h=100&fit=crop" class="h-14 w-14 rounded-full object-cover" alt="partner">
                            <div>
                                <p class="font-semibold text-white">Karim T.</p>
                                <p class="text-sm text-slate-400">Transporteur</p>
                            </div>
                        </div>
                        <p class="mt-6 text-slate-300">« J'utilise WasselM3ak pour remplir mes trajets. Les demandes sont claires et le paiement est fiable. »</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-gradient-to-r from-primary-500 via-primary-600 to-slate-900 p-1 shadow-2xl shadow-primary-500/20">
                <div class="rounded-[1.75rem] bg-slate-950 p-12 text-center text-white">
                    <p class="text-sm uppercase tracking-[0.28em] text-primary-300">Prêt à démarrer ?</p>
                    <h2 class="mt-4 text-4xl font-bold">Créez votre première demande en quelques clics</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Inscrivez-vous, publiez un trajet et laissez les transporteurs vous proposer leurs meilleures offres.</p>
                    <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a href="/signup" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-base font-semibold text-slate-950 shadow-lg shadow-black/20 transition hover:bg-slate-100">Créer une demande</a>
                        <a href="{{ route('showLogin') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-8 py-4 text-base font-semibold text-white transition hover:bg-white/10">Connexion</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
