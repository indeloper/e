import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const isProduction = window.location.protocol === 'https:';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? (isProduction ? 443 : 8080),
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: isProduction,
    enabledTransports: ['ws', 'wss'],
});
