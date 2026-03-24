// js/noti.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-messaging.js";

const firebaseConfig = {
  apiKey: "AIzaSyBq-FzvLoxf_3XYnRDZtVx4KRSjNeVJHEo",
  authDomain: "vrinda-6abfa.firebaseapp.com",
  projectId: "vrinda-6abfa",
  storageBucket: "vrinda-6abfa.firebasestorage.app",
  messagingSenderId: "243105983422",
  appId: "1:243105983422:web:da11dac09ff2880f5727ef",
  measurementId: "G-Y8JGJ187S7"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

const loginForm = document.querySelector("form");
const authTokenField = document.getElementById("authToken");

async function token() { // Stop for now

  try {
    const registration = await navigator.serviceWorker.register("js/sw.js");
    const token = await getToken(messaging, {
      serviceWorkerRegistration: registration,
      vapidKey: "BDTWW08n74xuLb6_lelW_KZm6kyQqeVCiPSIDorThK_NVTw5YNzqTQ-PdSvT009Me8WmbtlgP29MCtEkhAn4R9I"
    });

    if (token) {
      console.log(token)
      authTokenField.value = token;
    } else {
      console.warn("FCM token not available.");
    }
  } catch (err) {
    console.error("Error fetching token:", err);
  }
 // Now safely submit with token
};
setTimeout(token,100);
