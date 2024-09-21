import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Initialize Echo with Pusher
window.Pusher = Pusher;

// Preload the notification sound
const notificationSound = new Audio('/sound/notification.mp3');

// Function to request notification permission
function requestNotificationPermission() {
    if (Notification.permission === 'granted') {
        console.log('Notification permission already granted.');
    } else if (Notification.permission === 'default' || Notification.permission === 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');
            } else {
                console.log('Notification permission denied.');
            }
        });
    }
}

// Function to show browser notification
function showNotification(title, body) {
    if (Notification.permission === 'granted') {
        const notification = new Notification(title, { body });

        // Play sound after notification
        notificationSound.play().catch(error => {
            console.error('Error playing sound:', error);
        });
    } else {
        console.log('Notification permission not granted.');
    }
}

// Request permission on page load
document.addEventListener('DOMContentLoaded', () => {
    requestNotificationPermission();
});

// Initialize Echo
const echo = new Echo({
    broadcaster: 'pusher',
    key: '5ed5d6c08f4179d8b68d',
    cluster: 'ap1',
    encrypted: true,
});

// Subscribe to the channel
echo.channel('notification-channel')
    .listen('.sample.notification', (data) => {
        console.log('Received data:', data);

        // Show toast notification using Swal
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: data.message || "New Notification Received"
        });

        // Show browser notification and play sound automatically
        showNotification('New Notification', data.message || 'You have a new notification');
    });
