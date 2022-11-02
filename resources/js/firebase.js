import * as firebase from 'firebase/app';
import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";

const firebaseConfig = {
    apiKey: "AIzaSyBMOjUc7TI9ogqttinFKMVw0rsm_ZqBlT0",
    authDomain: "kingauto-8c673.firebaseapp.com",
    projectId: "kingauto-8c673",
    storageBucket: "kingauto-8c673.appspot.com",
    messagingSenderId: "564551464303",
    appId: "1:564551464303:web:dbe192a329dd775566e49a",
    measurementId: "G-YFNPX66T4D",
};


const db = firebase.initializeApp(firebaseConfig);


export default db;
