// 1. Firebase config
const firebaseConfig = {
  apiKey: "AIzaSyBs1PvTswVQCG63yXH2My4dMU3sKu67sVI",
  authDomain: "healthtracker-50807.firebaseapp.com",
  projectId: "healthtracker-50807",
  storageBucket: "healthtracker-50807.appspot.com", // ✅ Corrected domain
  messagingSenderId: "740545779904",
  appId: "1:740545779904:web:d5cb81e93d447580ac7525",
  measurementId: "G-QZMQSD2C2D"
};

// 3. Wait for DOM and initialize
window.addEventListener('DOMContentLoaded', () => {
  if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
  }

  const messaging = firebase.messaging();

  messaging.onMessage((payload) => {
    console.log('Foreground message received:', payload);
  
    const { title, body } = payload.notification;
    new Notification(title, { body });
  });
  

  if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
      .then((registration) => {
        console.log('Service Worker registered:', registration);

        return Notification.requestPermission().then(permission => {
          if (permission !== 'granted') {
            console.warn('Notification permission not granted.');
            return;
          }

          return messaging.getToken({
            vapidKey: 'BIafkPA52RMx9LUE76hwdsfvLmmCLyYgCCqgBrfPQCSw6fy2CWSgC0eoteldrXe0jkff91cTPPaMVFhsuuPJNrk',
            serviceWorkerRegistration: registration
          });
        });
      })
      .then(currentToken => {
        if (currentToken) {
          console.log('FCM Token:', currentToken);
          sendTokenToServer(currentToken);
        } else {
          console.warn('No registration token available.');
        }
      })
      .catch(err => {
        console.error('FCM setup error:', err);
      });
  } else {
    console.warn('Service workers or PushManager are not supported in this browser.');
  }
});

// 4. Send token to backend
function sendTokenToServer(token) {
  fetch('/save-fcm-token', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ token })
  })
  .then(() => {
    console.log('Token successfully sent to backend');
  })
  .catch(err => {
    console.error('Error sending token:', err);
  });
}
