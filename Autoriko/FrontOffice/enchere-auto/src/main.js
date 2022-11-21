import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import mitt from 'mitt';

window.api = axios.create({
  //baseURL: '/api', <-- PRODUCTION
  baseURL: 'http://autoriko.fr:12080/api', //<-- DEV
  headers: {
    Accept: 'application/json'
  },
  withCredentials: true
});

window.mitt = window.mitt || new mitt()

const emitter = mitt();

//Detect outside element click
const clickOutside = {
  beforeMount: (el, binding) => {
    el.clickOutsideEvent = (event) => {
      // here I check that click was outside the el and his children
      if (!(el == event.target || el.contains(event.target))) {
        // and if it did, call method provided in attribute value
        binding.value();
      }
    };
    document.addEventListener("click", el.clickOutsideEvent);
  },
  unmounted: el => {
    document.removeEventListener("click", el.clickOutsideEvent);
  },
};

const app = createApp(App);
app.directive("click-outside", clickOutside)
app.use(router)
app.use(store)
app.mount('#app')

//Vérifier les réponses des requests
//1: Navigateur plus connecté à internet ?
//2: Utilisateur déconnecté ?
window.api.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if(window.navigator.onLine == false){
    let timer = 10;
    console.log("Problème réseau : Votre navigateur n'est plus connecté à Internet.")
    let interval = setInterval(function () {
      console.log(`Nous renverons votre requêtes dans : ${timer}`)
      timer--
      if(timer <= 0){
        clearInterval(interval)
        window.api(error.config).then(res => {
          //Navigateur est de nouveau connecté à Internet = on actualise la page
          if(window.navigator.onLine)
            router.push(router.currentRoute._value.path)
        })
      }
    }, 1000);
  }
  else if((router.currentRoute._value.path != '/signin') && (401 === error.response.status)) {
    //alert((error.response.data.message_status) ? error.response.data.message_status : "Vous devez être connecté afin d'accèder à cette ressource ou exécuter cette action.")
    //store.commit('disconnectUser')
    //router.push('/signin')
    window.mitt.emit('disconnected')
  }
  else {
    return Promise.reject(error);
  }
});
