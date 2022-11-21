<template>
  <span class="ventes-panel-card-vente">
    <div class="card car">
      <img class="header-img" :src="this.vente.link_thumbnail" alt="Peugeot 208" />
      <div class="card-body">
        <div class="titre-marque">
          <h1 class="text-linear-gradient">{{ this.vente.title }}</h1>
          <img v-if="vente != null" :src="this.vente.car.brand.logo" :alt="this.vente.car.brand.name">
        </div>
        <p>{{ this.vente.car.motor }}</p>
        <ul class="info-voiture">
          <li>
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/speed.svg" alt="Voiture automatique" />
            <p>{{ this.vente.car.mileage }} Km</p>
          </li>
          <li>
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/calendar.svg" alt="Voiture automatique" />
            <p>{{ this.vente.car.year }}</p>
          </li>
          <li>
            <img v-if="url_img_transmission != null" :src="this.url_img_transmission" alt="Voiture automatique" />
            <p>{{ this.vente.car.transmission }}</p>
          </li>
          <li>
            <router-link :to="{ name: 'Vente', params: { uuid: this.vente.uuid } }" tag="options"><!-- TODO mettre le bon tag ici qui renvois vers les options sur la page VenteSeul -->
              <u>plus d'options</u> v
            </router-link>
          </li>
        </ul>
        <div v-if="forthcoming == false" class="info-vente">
          <div class="left">
            <p>{{ this.vente.price }} eur</p>
          </div>
          <div class="separation-bar-desc"></div>
          <div class="right">
            <p>{{ this.countdownText }}</p>
          </div>
        </div>
        <div v-else class="info-vente forthcoming">
          <div class="title-block">
            <div class="left">
              <h6>Prix départ</h6>
            </div>
            <div class="right">
              <h6>Début dans</h6>
            </div>
          </div>
          <div class="left">
            <p>0 eur</p>
          </div>
          <div class="separation-bar-desc"></div>
          <div class="right">
            <p>{{ this.countdownText }}</p>
          </div>
        </div>
        <router-link v-if="forthcoming == false" :to="{ name: 'Vente', params: { uuid: this.vente.uuid } }">
          <button class="see-vente">Encherir</button>
        </router-link>
        <button v-else class="see-vente">M'alerter</button>
      </div>
    </div>
  </span>
</template>

<script>

export default{
  props: {
    vente: null,
    forthcoming: {
      type: Boolean,
      default: false
    }
  },
  data(){
    return {
      end_timestamp: null,
      now_timestamp: null,
      timestampRefresh: null,
      url_logo_marque: null,
      url_img_transmission: null
    }
  },
  methods: {
    init(){
      if(this.vente.car.transmission.toLowerCase() == 'automatique')
        this.url_img_transmission = require(`@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/automatique.svg`)
      else if(this.vente.car.transmission.toLowerCase() == 'manuelle')
        this.url_img_transmission = require(`@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/manuelle.svg`)
    }
  },
  computed: {
    countdownText: function () {
      let remainingTime = this.end_timestamp - this.now_timestamp
      remainingTime = new Date(remainingTime);

      let diffDays = Math.ceil(remainingTime / (1000 * 60 * 60 * 24)) - 1;

      let day = remainingTime.getDate()
      let month = remainingTime.getMonth()

      let hours = ("0" + remainingTime.getHours()).slice(-2)
      let minutes = ("0" + remainingTime.getMinutes()).slice(-2)
      let seconds = ("0" + remainingTime.getSeconds()).slice(-2)

      return diffDays + 'J ' + hours + 'h ' + minutes + 'm ' + seconds + 's'
    }
  },
  beforeUnmount: function(){
    console.log('INTERVAL (vente) : SUPPRIMÉ')//TODO ne pas oublier de supprimer
    clearInterval(this.timestampRefresh)
  },
  mounted(){
    this.init()
    if(this.forthcoming == false){
      var end_timestamp = Date.parse(this.vente.end_date.replace(/ /, 'T'))
    }else{
      var end_timestamp = Date.parse(this.vente.start_date.replace(/ /, 'T'))
    }
    this.end_timestamp = end_timestamp

    this.timestampRefresh = setInterval(() => {
      console.log('INTERVAL (vente)')//TODO ne pas oublier de supprimer
      this.now_timestamp = new Date().getTime()
    }, 1000)
  }
}
</script>
