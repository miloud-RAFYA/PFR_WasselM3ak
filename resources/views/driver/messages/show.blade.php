@extends('layouts.dashboard')

@section('title', 'Conversation')

@section('sidebar')
    @include('driver.partials.sidebar', ['active' => 'messages'])
@endsection

@section('page-title', 'Conversation')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.7fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border bg-white p-6 shadow-sm">
                    <h1 class="text-2xl font-bold">
                        {{ $conversation->demande->ville_depart }} → {{ $conversation->demande->ville_arrive }}
                    </h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Expéditeur : {{ $conversation->expediteur->user->prenom ?? 'Inconnu' }}
                    </p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('driver.messages') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Retour</a>
                        <span class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">{{ $conversation->demande->reference ?? 'Réf. inconnue' }}</span>
                    </div>
                </div>

                <div class="rounded-3xl border bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Détails de la course</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $conversation->demande->ville_depart }} → {{ $conversation->demande->ville_arrive }}</h2>
                    <div class="mt-4 grid gap-3">
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm shadow-sm">
                            <p class="text-slate-500">Type de marchandise</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $conversation->demande->type_marchendise ?? 'Non précisé' }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm shadow-sm">
                            <p class="text-slate-500">Poids</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $conversation->demande->poids_kg ?? '—' }} kg</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm shadow-sm">
                            <p class="text-slate-500">Statut</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ ucfirst($conversation->demande->status ?? 'En attente') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border bg-slate-950 shadow-lg">

            {{-- HEADER CHAT --}}
            <div class="bg-orange-600 p-5 text-white rounded-t-3xl">
                <h2 class="text-xl font-semibold">Chat</h2>
                <div id="connection-status" class="text-xs opacity-75 mt-1">
                    Connecté
                </div>
            </div>

            {{-- MESSAGES --}}
            <div id="chat-box" class="h-[400px] overflow-y-auto p-6 space-y-4 bg-orange-50">
                @foreach ($conversation->messages as $message)
                    <div class="message-item flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}"
                         data-message-id="{{ $message->id }}">
                        <div class="max-w-[80%] px-4 py-3 rounded-2xl
                            {{ $message->sender_id === auth()->id() ? 'bg-orange-600 text-white' : 'bg-white border' }}">
                            <p class="message-content">{{ $message->content }}</p>
                            <span class="text-xs block mt-1 opacity-70">
                                {{ $message->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endforeach
                <div id="typing-indicator" class="text-sm text-gray-500 italic hidden">
                    <span>✏️</span> Quelqu'un est en train d'écrire...
                </div>
                <div id="loading-indicator" class="text-center text-gray-500 hidden">
                    <div class="inline-flex items-center gap-2">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <div class="bg-white p-4 border-t">
                <form id="chat-form" action="{{ route('driver.messages.send', $conversation) }}" method="POST">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-1 relative">
                            <textarea id="content" name="content" 
                                class="w-full border rounded-lg p-3 pr-12 resize-none"
                                placeholder="Écrire un message..."
                                rows="1"
                                style="min-height: 50px; max-height: 150px;"></textarea>
                            <div id="char-counter" class="absolute bottom-2 right-3 text-xs text-gray-400">
                                0/2000
                            </div>
                        </div>
                        <button type="submit" id="send-btn" 
                            class="bg-orange-600 hover:bg-orange-700 text-white px-6 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.4/echo.iife.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const conversationId = @json($conversation->id);
    const userId = @json(auth()->id());
    const sendRoute = "{{ route('driver.messages.send', $conversation) }}";
    
    let typingTimer = null;
    let isTyping = false;
    let loadingMore = false;
    let hasMoreMessages = true;
    let lastMessageId = @json($conversation->messages->first()?->id ?? null);
    let latestMessageId = @json($conversation->messages->last()?->id ?? null);
    
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const textarea = document.getElementById('content');
    const sendBtn = document.getElementById('send-btn');
    const charCounter = document.getElementById('char-counter');
    const connectionStatus = document.getElementById('connection-status');
    
    // Vérifier si le token CSRF existe
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token non trouvé!');
        showNotification('Erreur de sécurité: Token CSRF manquant. Rafraîchissez la page.', 'error');
    }
    
    // Auto-resize textarea
    function autoResizeTextarea() {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 150) + 'px';
    }
    
    textarea.addEventListener('input', autoResizeTextarea);
    
    // Character counter
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCounter.textContent = `${length}/2000`;
        if (length > 1900) {
            charCounter.classList.add('text-red-500');
        } else {
            charCounter.classList.remove('text-red-500');
        }
    });
    
    // Scroll to bottom function
    function scrollToBottom(smooth = true) {
        chatBox.scrollTo({
            top: chatBox.scrollHeight,
            behavior: smooth ? 'smooth' : 'auto'
        });
    }
    
    // Initial scroll to bottom
    setTimeout(scrollToBottom, 100);
    setInterval(pollNewMessages, 3000);
    
    // Initialize Pusher (avec gestion d'erreurs)
    try {
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: @json(env('PUSHER_APP_KEY')),
            cluster: @json(env('PUSHER_APP_CLUSTER')),
            wsHost: @json(env('PUSHER_HOST', '127.0.0.1')),
            wsPort: @json(env('PUSHER_PORT', 6001)),
            wssPort: @json(env('PUSHER_PORT', 6001)),
            forceTLS: @json(filter_var(env('PUSHER_APP_USE_TLS', false), FILTER_VALIDATE_BOOLEAN)),
            encrypted: @json(filter_var(env('PUSHER_APP_USE_TLS', false), FILTER_VALIDATE_BOOLEAN)),
            enabledTransports: ['ws', 'wss'],
            disableStats: true,
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            },
        });
        
        // Connection status
        if (window.Echo.connector && window.Echo.connector.pusher) {
            window.Echo.connector.pusher.connection.bind('connected', function() {
                connectionStatus.innerHTML = '✓ Connecté';
                connectionStatus.classList.add('text-orange-300');
                console.log('Pusher connected');
            });
            
            window.Echo.connector.pusher.connection.bind('disconnected', function() {
                connectionStatus.innerHTML = '⚠️ Déconnecté';
                connectionStatus.classList.remove('text-orange-300');
                console.log('Pusher disconnected');
            });
            
            window.Echo.connector.pusher.connection.bind('error', function(err) {
                console.error('Pusher error:', err);
                connectionStatus.innerHTML = '⚠️ Erreur de connexion';
            });
        }
        
        // Receive real-time messages
        window.Echo.channel('chat.' + conversationId)
            .listen('MessageSent', (e) => {
                console.log('Message received:', e);
                if (e.sender_id != userId) {
                    appendMessage(e);
                    scrollToBottom();
                }
            })
            .listen('user.typing', (e) => {
                const indicator = document.getElementById('typing-indicator');
                if (e.userName) {
                    indicator.innerHTML = `<span>✏️</span> ${e.userName} est en train d'écrire...`;
                    indicator.classList.remove('hidden');
                    
                    clearTimeout(window.typingTimeout);
                    window.typingTimeout = setTimeout(() => {
                        indicator.classList.add('hidden');
                    }, 2000);
                }
            });
    } catch (error) {
        console.error('Pusher initialization error:', error);
        connectionStatus.innerHTML = '⚠️ Erreur de connexion';
    }
    
    // Function to append message
    function appendMessage(message) {
        const isMe = message.sender_id == userId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-item flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in`;
        messageDiv.setAttribute('data-message-id', message.id);
        messageDiv.innerHTML = `
            <div class="max-w-[80%] px-4 py-3 rounded-2xl
                ${isMe ? 'bg-orange-600 text-white' : 'bg-white border'}">
                <p class="message-content">${escapeHtml(message.content)}</p>
                <span class="text-xs mt-1 block opacity-70">${message.time}</span>
            </div>
        `;
        chatBox.appendChild(messageDiv);
        latestMessageId = Math.max(latestMessageId || 0, message.id);
    }
    
    // Fonction pour afficher les notifications
    function showNotification(message, type = 'info') {
        // Supprimer les notifications existantes
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 animate-fade-in ${
            type === 'error' ? 'bg-red-500 text-white' : 
            type === 'warning' ? 'bg-yellow-500 text-white' : 
            'bg-emerald-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                ${type === 'error' ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : ''}
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
    
    // Send message with AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = textarea.value.trim();
        if (!content) {
            showNotification('Veuillez écrire un message avant d\'envoyer.', 'warning');
            return;
        }
        
        // Disable button and show loading
        sendBtn.disabled = true;
        const originalBtnHtml = sendBtn.innerHTML;
        sendBtn.innerHTML = `
            <svg class="w-5 h-5 inline-block animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Envoi...
        `;
        
        $.ajax({
            url: sendRoute,
            method: 'POST',
            data: {
                content: content,
                _token: csrfToken
            },
            success: function(response) {
                const tempMessage = {
                    id: response.id || Date.now(),
                    content: content,
                    sender_id: userId,
                    time: new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})
                };
                appendMessage(tempMessage);
                latestMessageId = response.id || latestMessageId;
                scrollToBottom();
                textarea.value = '';
                autoResizeTextarea();
                if (charCounter) charCounter.textContent = '0/2000';
                showNotification('Message envoyé !', 'success');
            },
            error: function(xhr) {
                console.error('Error sending message:', xhr);
                const message = xhr.responseJSON?.message || 'Erreur lors de l\'envoi du message. Veuillez réessayer.';
                showNotification(message, 'error');
            },
            complete: function() {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalBtnHtml;
                textarea.focus();
            }
        });
    });
    
    // Typing indicator with AJAX
    let typingTimeout;
    textarea.addEventListener('input', function() {
        if (!isTyping && this.value.length > 0) {
            isTyping = true;
            
            $.ajax({
                url: `/conversations/${conversationId}/typing`,
                method: 'POST',
                data: {
                    typing: true,
                    _token: csrfToken
                }
            });
            
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                isTyping = false;
                $.ajax({
                    url: `/conversations/${conversationId}/typing`,
                    method: 'POST',
                    data: {
                        typing: false,
                        _token: csrfToken
                    }
                });
            }, 1000);
        }
    });
    
    // Load more messages on scroll (infinite scroll)
    chatBox.addEventListener('scroll', function() {
        if (chatBox.scrollTop === 0 && !loadingMore && hasMoreMessages) {
            loadMoreMessages();
        }
    });
    
    function loadMoreMessages() {
        loadingMore = true;
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        $.ajax({
            url: `/conversations/${conversationId}/messages`,
            method: 'GET',
            data: {
                last_id: lastMessageId
            },
            success: function(response) {
                if (response.messages && response.messages.length > 0) {
                    response.messages.forEach(message => {
                        prependMessage(message);
                    });
                    lastMessageId = response.messages[response.messages.length - 1]?.id;
                    hasMoreMessages = response.has_more;
                } else {
                    hasMoreMessages = false;
                }
            },
            error: function(xhr) {
                console.error('Error loading messages:', xhr);
            },
            complete: function() {
                loadingMore = false;
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
            }
        });
    }

    function pollNewMessages() {
        if (!latestMessageId) {
            return;
        }
        
        $.ajax({
            url: `/conversations/${conversationId}/messages`,
            method: 'GET',
            data: {
                since_id: latestMessageId
            },
            success: function(response) {
                if (response.messages && response.messages.length > 0) {
                    response.messages.forEach(message => {
                        appendMessage(message);
                        latestMessageId = Math.max(latestMessageId, message.id);
                    });
                    scrollToBottom();
                }
            },
            error: function(xhr) {
                console.error('Error polling messages:', xhr);
            }
        });
    }
    
    function prependMessage(message) {
        const isMe = message.sender_id == userId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-item flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in`;
        messageDiv.innerHTML = `
            <div class="max-w-[80%] px-4 py-3 rounded-2xl
                ${isMe ? 'bg-orange-600 text-white' : 'bg-white border'}">
                <p>${escapeHtml(message.content)}</p>
                <span class="text-xs mt-1 block opacity-70">${message.time}</span>
            </div>
        `;
        chatBox.insertBefore(messageDiv, chatBox.firstChild);
        
        // Maintain scroll position
        const oldScrollHeight = chatBox.scrollHeight;
        chatBox.scrollTop = chatBox.scrollHeight - oldScrollHeight;
    }
    
    // Escape HTML function
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Focus textarea on page load
    textarea.focus();
    
    // Keyboard shortcut (Ctrl+Enter to send)
    textarea.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });
});
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endpush