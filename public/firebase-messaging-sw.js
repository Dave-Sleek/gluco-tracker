// public/firebase-messaging-sw.js

// Import the Firebase compat SDKs
importScripts('https://www.gstatic.com/firebasejs/11.10.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/11.10.0/firebase-messaging-compat.js');

// Initialize Firebase in the service worker
firebase.initializeApp({
  apiKey: "AIzaSyBs1PvTswVQCG63yXH2My4dMU3sKu67sVI",
  authDomain: "healthtracker-50807.firebaseapp.com",
  projectId: "healthtracker-50807",
  storageBucket: "healthtracker-50807.appspot.com", // ✅ Fix typo here
  messagingSenderId: "740545779904",
  appId: "1:740545779904:web:d5cb81e93d447580ac7525",
  measurementId: "G-QZMQSD2C2D"
});

// Retrieve messaging instance
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function(payload) {
  console.log('[Service Worker] Background message received:', payload);

  const notificationTitle = payload.notification?.title || 'Notification';
  const notificationOptions = {
    body: payload.notification?.body || '',
    icon: '/icons/icon-192x192.png' // ✅ Make sure this icon exists and is accessible
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});

