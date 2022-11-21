<template>
  <div class="main-content">
    <div class="block-confiance">
      <ul class="align-center-small">
        <li>
          <img src="@/assets/img/pages/vente/SECTION_1/LOGO/expertisee.png" alt="Expertisées" />
          <p>Expertisées</p>
        </li>
        <li>
          <img src="@/assets/img/pages/vente/SECTION_1/LOGO/garantie.png" alt="Garanties" />
          <p>Garanties 6 mois</p>
        </li>
        <li>
          <img src="@/assets/img/pages/vente/SECTION_1/LOGO/ct.png" alt="Controle technique" />
          <p>Contrôle Technique de - 1 mois</p>
        </li>
        <li>
          <img src="@/assets/img/pages/vente/SECTION_1/LOGO/livrees.png" alt="Livrées" />
          <p>Livrées gratuitement à votre domicile</p>
        </li>
      </ul>
    </div>
    <section class="section_1 block-vente">
      <div class="left" id="photo_vignette_xl" :style="{ 'background-image' : 'url(' + ((vente) ? vente.link_thumbnail : '') + ')'}">
        <ul class="desc">
          <li>
            <img v-if="url_img_transmission_vente != null" :src="url_img_transmission_vente" />
            <p v-if="vente">{{ vente.car.transmission }}</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/speed.svg" />
            <p v-if="vente">{{ vente.car.mileage }} Km</p>
          </li>
          <li>
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/automatique.svg" />
            <p v-if="vente">{{ vente.car.owner_number }}ème main</p>
          </li>
          <li>
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/automatique.svg" />
            <p v-if="vente">{{ vente.car.energy }}</p>
          </li>
        </ul>
      </div>
      <div class="right">
        <div id="alert_add_amount" @click="closeAlertAddAmount" class="section-alert-container" :class="(showAlertAddAmount == true) ? 'show' : ''">
          <p>Votre ajout a été effectué</p>
          <div class="alert-chip-container">
            <div class="alert-chip">
              <span v-if="selectedAmount != null">{{ selectedAmount }}€</span>
            </div>
          </div>
          <p>Vous êtes désormais le détenteur de l'offre !</p>
        </div>
        <div class="block-decompte">
          <h2 class="text-linear-gradient">La vente se termine dans :</h2>
          <div class="decompte">
            <div class="decompte-grp">
              <p class="number text-linear-gradient" v-if="countdownDayText">{{ countdownDayText }}</p>
              <p class="intitule">Jours</p>
            </div>
            <div class="decompte-grp">
              <p class="number text-linear-gradient" v-if="countdownHourText">{{ countdownHourText }}</p>
              <p class="intitule">Heures</p>
            </div>
            <div class="decompte-grp">
              <p class="number text-linear-gradient" v-if="countdownMinuteText">{{ countdownMinuteText }}</p>
              <p class="intitule">Minutes</p>
            </div>
            <div class="decompte-grp">
              <p class="number text-linear-gradient" v-if="countdownSecondText">{{ countdownSecondText }}</p>
              <p class="intitule">Secondes</p>
            </div>
          </div>
        </div>
        <hr>
        <div class="block-offre-actuelle">
          <h2 class="text-linear-gradient">Offre actuelle</h2>
          <div class="block-price">
            <p v-if="vente" class="price text-linear-gradient">{{ vente.price }}€</p>
            <p v-if="user_participate && user_last_offre == null" class="text">Vous n'avez encore fait d'offre</p>
            <div v-else-if="user_participate && user_last_offre == vente.price" class="block-offre-stats winner">
              <p class="text">Vous êtes actuelement le détenteur de l'offre</p>
              <!--<p class="text" style="margin-bottom: 0;">Vous avez monté l'offre à <b>{{ user_last_offre }}€</b></p>-->
            </div>
            <div v-else-if="user_participate && user_last_offre != vente.price" class="block-offre-stats looser">
              <p class="text">Vous n'êtes pas le détenteur de l'offre</p>
            </div>
          </div>
          <p v-if="vente && vente.number_offre > 0" class="nombre-offre">{{ vente.number_offre }} offre(s)</p>
          <p v-else class="nombre-offre">Personne n'a encore fait d'offre</p>
          <p class="estimation">Estimation de l'expert : <b>30 000 € - 38 000€</b></p>
          <p class="moment-ideal">C'est le moment ideal pour commencer à faire une offre</p>
        </div>
        <hr>
        <div v-if="isConnected == true && user_participate == true" class="block-encherir">
          <h2 class="text-linear-gradient">Faire une offre</h2>
          <div class="block-chip">
            <div class="chip" :class="(selectedAmount == 50) ? 'selected' : ''" @click="changeAmount(50)">50€</div>
            <div class="chip" :class="(selectedAmount == 100) ? 'selected' : ''" @click="changeAmount(100)">100€</div>
            <div class="chip" :class="(selectedAmount == 250) ? 'selected' : ''" @click="changeAmount(250)">250€</div>
            <div class="chip" :class="(selectedAmount == 500) ? 'selected' : ''" @click="changeAmount(500)">500€</div>
            <div class="chip" :class="(selectedAmount == 1000) ? 'selected' : ''" @click="changeAmount(1000)">1000€</div>
          </div>
          <div class="container-send-offre">
            <div class="block-envoyer-offre" v-if="selectedAmount != null && !offre_auto_send">
              <button type="button" name="button" @click="addAmount">Ajouter {{ selectedAmount }}€ à l'offre</button>
            </div>
            <div class="block-offre-auto">
              <div class="block-enable">
                <h4 @click="offre_auto_send = !offre_auto_send">Activer l'ajout automatique</h4>
                <label class="switch-checkbox">
                  <input type="checkbox" v-model="offre_auto_send">
                  <span class="slider round"></span>
                </label>
              </div>
              <p class="question">Qu'est-ce que l'ajout automatique ?</p>
            </div>
          </div>
        </div>
        <button v-if="user_participate == false" @click="signupOffre" type="button" class="btn-inscription">Participer</button>
      </div>
    </section>
    <section class="section_2 block-voiture align-center">
      <h1 class="text-linear-gradient">Caractéristiques techniques</h1>
      <div class="block-sound-description">
        <div class="left">
          <p>Ecouter le bruit du moteur :</p>
          <audio class="original-audio-bar" controls @timeupdate="updateBar">
              <source v-if="vente" :src="vente.car.engine_sound" type="audio/mp3">
          </audio>
          <div class="custom-audio-bar">
            <div class="play-group">
              <div class="button-play" @click="togglePlaying">
                <svg class="play" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="transform:;-ms-filter:"><path d="M7 6L7 18 17 12z"></path></svg>
                <svg class="pause" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: none;transform:;-ms-filter:"><path d="M8 7H11V17H8zM13 7H16V17H13z"></path></svg>
              </div>
              <div class="bar-time">
                <div class="cursor-background"></div>
                <div class="cursor"></div>
              </div>
              <p class="audio-time"></p>
            </div>
            <div class="sound-group">
              <div class="button-volume" @click="toggleMute">
                <svg class="volume-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="transform:;-ms-filter:"><path d="M16,21c3.527-1.547,5.999-4.909,5.999-9S19.527,4.547,16,3v2c2.387,1.386,3.999,4.047,3.999,7S18.387,17.614,16,19V21z"></path><path d="M16 7v10c1.225-1.1 2-3.229 2-5S17.225 8.1 16 7zM4 17h2.697L14 21.868V2.132L6.697 7H4C2.897 7 2 7.897 2 9v6C2 16.103 2.897 17 4 17z"></path></svg>
                <svg class="volume-mute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: none;transform:;-ms-filter:"><path d="M7.727 6.313l-4.02-4.02L2.293 3.707l18 18 1.414-1.414-2.02-2.02c1.44-1.687 2.312-3.851 2.312-6.273 0-4.091-2.472-7.453-5.999-9v2c2.387 1.386 3.999 4.047 3.999 7 0 1.832-.63 3.543-1.671 4.914l-1.286-1.286C17.644 14.536 18 13.19 18 12c0-1.771-.775-3.9-2-5v7.586l-2-2V2.132L7.727 6.313zM4 17h2.697L14 21.868v-3.747L3.102 7.223C2.451 7.554 2 8.222 2 9v6C2 16.103 2.897 17 4 17z"></path></svg>
              </div>
              <div class="bar-volume">
                <input class="bar-range" @input="updateVolume" type="range" min="0" max="10" value="10">
              </div>
            </div>
          </div>
        </div>
        <div class="right">
          <h3>Description du véhicule</h3>
          <p v-if="vente">{{ vente.car.description }}</p>
        </div>
      </div>
      <div class="block-smart-info">
        <ul class="card">
          <li>
            <img v-if="url_img_transmission_vente != null" :src="url_img_transmission_vente" />
            <h3>Transmission</h3>
            <p v-if="vente">{{ vente.car.transmission }}</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Kilometrage</h3>
            <p v-if="vente">{{ vente.car.mileage }} Km</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Année</h3>
            <p v-if="vente">{{ vente.car.year }}</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Propriétaires</h3>
            <p v-if="vente">{{ vente.car.owner_number }}ème main</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Portes</h3>
            <p v-if="vente">{{ vente.car.number_of_door }}</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Moteur</h3>
            <p v-if="vente">{{ vente.car.motor }}</p>
          </li>
          <li>
            <img src="@/assets/img/pages/vente/SECTION_1/LEFT_DESC/automatique.png" />
            <h3>Energie</h3>
            <p v-if="vente">{{ vente.car.energy }}</p>
          </li>
        </ul>
      </div>
      <div class="block-video-car">
        <p>Regarder la vidéo complète de la voiture :</p>
        <div class="block-video-car-desc">
          <div class="left">
            <div class="show-video" style="display: none;">
              <video v-if="vente" controls>
                <source :src="vente.car.video" type="video/mp4">
                Sorry, your browser doesn't support embedded videos.
              </video>
            </div>
            <div class="show-vignette">
              <img v-if="vente" :src="vente.link_thumbnail" alt="">
              <svg aria-hidden="true" focusable="false" style="width:0;height:0;position:absolute;">
                <linearGradient id="gradient-horizontal">
                  <stop offset="0%" stop-color="#aa1abb" />
                  <stop offset="100%" stop-color="#0552fa" />
                </linearGradient>
              </svg>
              <svg @click="play_video()" class="play-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="transform:;-ms-filter:">
                <path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.514,2,12,2z M12,20c-4.411,0-8-3.589-8-8s3.589-8,8-8 s8,3.589,8,8S16.411,20,12,20z"></path>
                <path d="M9 17L17 12 9 7z"></path>
              </svg>
            </div>
          </div>
          <div class="right">
            <ul>
              <li>
                <p>Type de voiture</p>
                <h5 v-if="vente">{{ vente.car.category.name }}</h5>
              </li>
              <hr>
              <li>
                <p>Numéro d'identification</p>
                <h5 v-if="vente">{{ vente.car.identification_number }}</h5>
              </li>
              <hr>
              <li>
                <p>Couleur extèrieure</p>
                <h5 v-if="vente">{{ vente.car.color }}</h5>
              </li>
              <hr>
              <li>
                <p>Intérieur</p>
                <h5 v-if="vente">{{ vente.car.interior_description }}</h5>
              </li>
              <hr>
              <li>
                <p>Traction</p>
                <h5 v-if="vente">{{ vente.car.transmission }}</h5>
              </li>
              <hr>
              <li v-if="vente">
                <p>CO2</p>
                <h5>{{ vente.car.co2 }}</h5>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="block-photo-additionnelle">
        <h1 class="text-linear-gradient">Photos additionnelles</h1>
        <div class="block-galeries" v-if="galeries">
          <CardGalerie
            v-for="galerie in galeries"
            v-bind:galerie="galerie"
          ></CardGalerie>
        </div>
      </div>
    </section>
    <section class="section_3 backgrounds-container">
      <div class="bg-1-container">
        <div class="bg"></div>
      </div>
      <h1 class="section-title text-linear-gradient align-center-small">Offres en cours</h1>
      <SeparationBarMarques></SeparationBarMarques>
      <div class="filter align-center-small">
        <ul class="first-line">
          <li>
            <router-link :to="{path: '/ventes_panel', query: { category: 'compact' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/compact.png" alt="Voiture compact" />
                <p>Compact</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { category: 'berline' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/berline.png" alt="Voiture berline" />
                <p>Berline</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { category: '4x4' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/4x4.png" alt="Voiture 4x4" />
                <p>4x4</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { category: 'coupe' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/coupe.png" alt="Voiture coupe" />
                <p>Coupe</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { category: 'cabriolet' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/cabriolet.png" alt="Voiture cabriolet" />
                <p>Cabriolet</p>
              </div>
            </router-link>
          </li>
        </ul>
        <ul class="second-line">
          <li>
            <router-link :to="{path: '/ventes_panel', query: { transmission: 'automatique' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/automatique.png" alt="Voiture automatique" />
                <p>Automatique</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { transmission: 'manuelle' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/manuelle.png" alt="Voiture manuelle" />
                <p>Manuelle</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { energy: 'electrique' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/electrique.png" alt="Voiture electrique" />
                <p>Electrique</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { energy: 'essence' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/essence.png" alt="Voiture essence" />
                <p>Essence</p>
              </div>
            </router-link>
          </li>
          <li>
            <router-link :to="{path: '/ventes_panel', query: { energy: 'diesel' }, hash:'#first_section'}">
              <div class="filter-btn">
                <img src="@/assets/img/pages/home/SECTION_3/ICON_FILTER/essence.png" alt="Voiture diesel" />
                <p>Diesel</p>
              </div>
            </router-link>
          </li>
        </ul>
      </div>
      <div class="section_vente align-center">
        <div class="list-vente" v-if="ventes">
            <CardVente
              v-for="elem in ventes"
              v-bind:vente="elem.vente"
            ></CardVente>
          <div class="card see-all" v-if="ventes.length > 5">
            <router-link to="/ventes_panel">
              <button>
                Voir toutes les ventes <span class="arrow">></span>
              </button>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>

import axios from 'axios'
import $ from 'jquery'
import { nextTick } from 'vue'
import CardVente from '@/components/Vente/CardVente.vue'
import CardGalerie from '@/components/Vente/CardGalerie.vue'
import SeparationBarMarques from '@/components/MAIN/separation_bar_marques.vue'

export default {
  name: 'Vente',
  components:{
    CardVente,
    CardGalerie,
    SeparationBarMarques
  },
  data() {
    return {
      uuid: null,
      vente: null,
      ventes: null,
      galeries: null,
      selectedAmount: null,
      showAlertAddAmount: false,
      offre_auto_send: false,
      user_participate: false,
      user_last_offre: null,
      dataSoftRefresh: null,
      isConnected: false,

      end_timestamp_vente: null,
      now_timestamp_vente: null,
      timestampRefresh_vente: null,
      url_logo_marque_vente: null,
      url_img_transmission_vente: null,

      originalAudioElem: null,
      customAudioBar: null,
      customAudioBarCursor: null,
      customAudioBarCursorBackground: null,
      customPlaySvg: null,
      customPauseSvg: null,
      customVolumeFullSvg: null,
      customVolumeMuteSvg: null,
      customVolumeBar: null,
      audioPlayed: null,
      audioDuration: null,

      videoContainerElem: null,
      videoVignetteContainerElem: null,

      //blockGaleriesElem: null

    }
  },
  methods: {
    init(){
      this.loadDataListVentes()
      this.loadData()
      this.dataSoftRefresh = setInterval(() => {
        this.loadSoftInfo()
      }, 1000)
    },

    signupOffre(){
      let data = { 'uuid': this.uuid }
      api.post('/ventes/offre/inscription', data).then(response => {
        this.user_participate = true
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },

    changeAmount(amount){
      if(this.offre_auto_send){
        this.selectedAmount = amount
        this.addAmount()
      }else{
        if(this.selectedAmount != amount){
          this.selectedAmount = amount
        }else{
          this.selectedAmount = null
        }
      }
    },

    addAmount(){
      if(this.selectedAmount != null){
        let data = {
          'uuid': this.uuid,
          'price': this.selectedAmount,
          'actualPrice': this.vente.price
        }
        api.post('/ventes/offre', data).then(response => {
          this.vente.price = this.vente.price + this.selectedAmount
          this.vente.number_offre = this.vente.number_offre + 1
          this.user_last_offre = this.selectedAmount
          $('#alert_add_amount').css('display', 'flex')
          let app = this
          setTimeout(function(){ app.showAlertAddAmount = true }, 500)
          setTimeout(function(){ app.closeAlertAddAmount() }, 3500)
        }).catch(error => {
          alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        }).catch(() => {
          alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        })
      }
    },

    closeAlertAddAmount(){
      this.showAlertAddAmount = false
      let app = this
      app.selectedAmount = null
      setTimeout(function(){
        $('#alert_add_amount').css('display', 'none')
      }, 800);
    },

    convertElapsedTime(inputSeconds){
      let seconds = Math.floor(inputSeconds % 60)
      if(seconds < 10){
        seconds = "0" + seconds
      }
      let minutes = Math.floor(inputSeconds / 60)
      return minutes + ":" + seconds
    },

    updateBar(){
      let currentTime = this.originalAudioElem.currentTime
      if(currentTime == this.audioDuration){
        $(this.customAudioBarCursor).css('left', '100%')
        $(this.customAudioBarCursorBackground).css('width', '100%')
        this.togglePlaying()
      }else{
        let percentage = (currentTime / this.audioDuration) * 100
        $(this.customAudioBarCursor).css('left', percentage + '%')
        $(this.customAudioBarCursorBackground).css('width', percentage + '%')
      }
    },
    togglePlaying(){
      this.audioPlayed = !this.audioPlayed
      let method = null
      if(!this.audioPlayed){
        $(this.customPauseSvg).css('display', 'none')
        $(this.customPlaySvg).css('display', 'block')
        method = 'pause'
      }else{
        $(this.customPlaySvg).css('display', 'none')
        $(this.customPauseSvg).css('display', 'block')
        method = 'play'
      }
      this.originalAudioElem[method]()
    },
    toggleMute(){
      if(!this.originalAudioElem['muted']){
        $(this.customVolumeFullSvg).css('display', 'none')
        $(this.customVolumeMuteSvg).css('display', 'block')
        this.originalAudioElem['muted'] = true
      }else{
        $(this.customVolumeMuteSvg).css('display', 'none')
        $(this.customVolumeFullSvg).css('display', 'block')
        this.originalAudioElem['muted'] = false
      }
    },
    updateVolume(event){
      let value = event.target.value / 10
      this.originalAudioElem['volume'] = value
    },
    play_video(){
      $(this.videoContainerElem).css('display', 'block')
      $(this.videoVignetteContainerElem).css('display', 'none')

      $(this.videoContainerElem).find('video')[0].play()
    },
    loadSoftInfo(){
      api.get('/ventesSoft/' + this.uuid).then(response => {
        this.vente.price = response.data.price
        this.vente.enable = response.data.enable
        this.vente.number_offre = response.data.number_offre
        this.user_participate = response.data.user_participate
        this.user_last_offre = response.data.user_last_offre
        console.log(response.data)
      }).catch(error => {
        //alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        //alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    loadDataListVentes(){
      api.get('/ventes?size=7').then(response => {
        this.ventes = response.data.ventes.filter(elem => elem.vente.uuid != this.uuid)
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    loadData(){
      api.get('/ventes/' + this.uuid).then(response => {
        this.vente = response.data.vente
        this.galeries = response.data.vente.car.gallery
        this.user_participate = response.data.vente.user_participate
        this.user_last_offre = response.data.vente.user_last_offre

        let end_timestamp_vente = Date.parse(this.vente.end_date.replace(/ /, 'T'))
        console.log('WARNING LUC: ' + end_timestamp_vente)
        this.end_timestamp_vente = end_timestamp_vente

        this.timestampRefresh_vente = setInterval(() => {
          console.log('INTERVAL (vente)')//TODO ne pas oublier de supprimer
          this.now_timestamp_vente = new Date().getTime()
        }, 1000)
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    }
  },
  computed: {
    countdownDayText: function () {
      if(this.end_timestamp_vente && this.now_timestamp_vente){
        let remainingTime = this.end_timestamp_vente - this.now_timestamp_vente
        remainingTime = new Date(remainingTime);

        let diffDays = Math.ceil(remainingTime / (1000 * 60 * 60 * 24)) - 1;

        return diffDays
      }else {
        return false
      }
    },
    countdownHourText: function () {
      if(this.end_timestamp_vente && this.now_timestamp_vente){
        let remainingTime = this.end_timestamp_vente - this.now_timestamp_vente
        remainingTime = new Date(remainingTime);

        let hours = ("0" + remainingTime.getHours()).slice(-2)

        return hours
      }
      else{
        return false
      }
    },
    countdownMinuteText: function () {
      if(this.end_timestamp_vente && this.now_timestamp_vente){
        let remainingTime = this.end_timestamp_vente - this.now_timestamp_vente
        remainingTime = new Date(remainingTime);

        let minutes = ("0" + remainingTime.getMinutes()).slice(-2)

        return minutes
      }
      else{
        return false
      }
    },
    countdownSecondText: function () {
      if(this.end_timestamp_vente && this.now_timestamp_vente){
        let remainingTime = this.end_timestamp_vente - this.now_timestamp_vente
        remainingTime = new Date(remainingTime);

        let seconds = ("0" + remainingTime.getSeconds()).slice(-2)

        return seconds
      }
      else{
        return false
      }
    }
  },
  watch: {
    vente: function(){
      if(this.vente.car.transmission.toLowerCase() == 'automatique')
        this.url_img_transmission_vente = require(`@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/automatique.svg`)
      else if(this.vente.car.transmission.toLowerCase() == 'manuelle')
        this.url_img_transmission_vente = require(`@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/manuelle.svg`)

      var self = this
      nextTick()
        .then(function () {
          self.originalAudioElem = document.querySelectorAll('.original-audio-bar')[0]
          self.customAudioBar = document.querySelectorAll('.custom-audio-bar .bar-time')[0]
          self.customAudioBarCursor = document.querySelectorAll('.custom-audio-bar .bar-time .cursor')[0]
          self.customAudioBarCursorBackground = document.querySelectorAll('.custom-audio-bar .bar-time .cursor-background')[0]
          self.customPlaySvg = document.querySelectorAll('.custom-audio-bar .play')[0]
          self.customPauseSvg = document.querySelectorAll('.custom-audio-bar .pause')[0]
          self.customVolumeFullSvg = document.querySelectorAll('.custom-audio-bar .volume-full')[0]
          self.customVolumeMuteSvg = document.querySelectorAll('.custom-audio-bar .volume-mute')[0]
          self.customVolumeBar = document.querySelectorAll('.custom-audio-bar .bar-range')[0]
          self.audioPlayed = false
          self.audioDuration = null
          self.videoContainerElem = document.querySelectorAll('.block-video-car-desc .left .show-video')[0]
          self.videoVignetteContainerElem = document.querySelectorAll('.block-video-car-desc .left .show-vignette')[0]

          self.originalAudioElem.addEventListener('loadedmetadata', function(){
            /* CUSTOM AUDIO BAR */
            self.audioDuration = self.originalAudioElem.duration
            self.customVolumeBar.value = self.originalAudioElem['volume'] * 10
            //////////////////////
        });
      });
    }
  },
  created(){
    this.uuid = this.$route.params.uuid
    if(this.$store.state.user && this.$store.state.userToken){
      this.isConnected = true
    }else{
      this.isConnected = false
    }
  },
  mounted(){
    this.init()
  },
  beforeUnmount: function(){
    console.log('INTERVAL (vente) : SUPPRIMÉ')//TODO ne pas oublier de supprimer
    clearInterval(this.timestampRefresh_vente)
    clearInterval(this.dataSoftRefresh)
  }
}
</script>

<style scoped src="./../assets/css/pages/vente/card-vente.css"></style>
<style scoped src="./../assets/css/pages/vente/main.css"></style>
<style scoped lang="scss">
  .block-vente ul{
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.35) 60%);
    height: 20%;
    bottom: 0 !important;
  }
  .block-vente .left img{
    filter: invert(1);
  }
  .block-voiture{
    h1{
      margin-bottom: 2rem;
    }
    .block-sound-description{
      align-items: flex-start !important;
      .right{
        margin-top: -2rem;
      }
    }
  }

  .show-video{
    video{
      width: 100%;
    }
  }

  .block-vente{
    min-height: 70vh;

    .right{
      place-self: center;
    }
  }
</style>
<style lang="scss">
  .vente-card-vente{
    @import "@/assets/css/pages/vente/card-vente";
  }
</style>
