energy<template>
  <div class="main-content">
    <div class="backgrounds-container">
      <div class="bg-1-container">
        <div class="bg"></div>
      </div>
      <div class="bg-2-container">
        <div class="bg"></div>
      </div>
      <div class="bg-3-container">
        <div class="bg"></div>
      </div>
      <div class="bg-4-container">
        <div class="bg"></div>
      </div>
      <div class="bg-5-container">
        <div class="bg"></div>
      </div>
    </div>
    <SeparationBarMarques></SeparationBarMarques>
    <div class="align-center">
      <div class="filter">
        <ul class="first-line">
          <li @click="changeCategory('compact')" :class="(ventesCategory == 'compact') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/compact.svg" alt="Voiture compact" />
            <p>Compact</p>
          </li>
          <li @click="changeCategory('berline')" :class="(ventesCategory == 'berline') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/berline.svg" alt="Voiture berline" />
            <p>Berline</p>
          </li>
          <li @click="changeCategory('4x4')" :class="(ventesCategory == '4x4') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/4x4.svg" alt="Voiture 4x4" />
            <p>4x4</p>
          </li>
          <li @click="changeCategory('coupe')" :class="(ventesCategory == 'coupe') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/coupe.svg" alt="Voiture coupe" />
            <p>Coupe</p>
          </li>
          <li @click="changeCategory('cabriolet')" :class="(ventesCategory == 'cabriolet') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/cabriolet.svg" alt="Voiture cabriolet" />
            <p>Cabriolet</p>
          </li>
        </ul>
        <ul class="second-line">
          <li @click="changeTransmission('automatique')" :class="(ventesTransmission == 'automatique') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/automatique.svg" alt="Voiture automatique" />
            <p>Automatique</p>
          </li>
          <li @click="changeTransmission('manuelle')" :class="(ventesTransmission == 'manuelle') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/manuelle.svg" alt="Voiture manuelle" />
            <p>Manuelle</p>
          </li>
          <li @click="changeEnergy('electrique')" :class="(ventesEnergy == 'electrique') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/electrique.svg" alt="Voiture electrique" />
            <p>Electrique</p>
          </li>
          <li @click="changeEnergy('essence')" :class="(ventesEnergy == 'essence') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/essence.svg" alt="Voiture essence" />
            <p>Essence</p>
          </li>
          <li @click="changeEnergy('diesel')" :class="(ventesEnergy == 'diesel') ? 'selected' : ''">
            <img src="@/assets/img/pages/ventes-panel/SECTION_3/ICON_FILTER/essence.svg" alt="Voiture diesel" />
            <p>Diesel</p>
          </li>
        </ul>
      </div>
      <div class="sections-container">
        <aside class="sections-aside">
          <div class="show-by">
            <h1>Afficher par</h1>
            <div>
              <input checked type="radio" name="show-by" value="date_start_ascending" id="date_start_ascending">
              <label for="date_start_ascending">Date début croissante</label>
            </div>
            <div>
              <input type="radio" name="show-by" value="date_start_descending" id="date_start_descending">
              <label for="date_start_descending">Date début décroissante</label>
            </div>
            <div>
              <input type="radio" name="show-by" value="price_ascending" id="price_ascending">
              <label for="price_ascending">Prix croissant</label>
            </div>
            <div>
              <input type="radio" name="show-by" value="price_descending" id="price_descending">
              <label for="price_descending">Prix décroissant</label>
            </div>
          </div>
          <div class="kilometers">
            <h1>Kilomètres</h1>
            <div>
              <label for="min-kilometers">Minimum</label>
              <input type="text" name="min-kilometers" placeholder="0" />
            </div>
            <div>
              <label for="max-kilometers">Maximum</label>
              <input type="text" name="max-kilometers" placeholder="0" />
            </div>
          </div>
          <div class="prices">
            <h1>Prix</h1>
            <div>
              <label for="min-price">Minimum</label>
              <input type="text" name="min-price" placeholder="0" />
            </div>
            <div>
              <label for="max-price">Maximum</label>
              <input type="text" name="max-price" placeholder="0" />
            </div>
          </div>
          <div class="vehicule-type">
            <h1>Type véhicule</h1>
            <ul>
              <li>Compact</li>
              <li>Berline</li>
              <li>4x4</li>
              <li>Coupe</li>
              <li>Cabriolet</li>
            </ul>
          </div>
        </aside>
        <div class="block_ventes">
          <section v-if="isConnected == true && ventesParticipation != null && ventesParticipation != false" class="section_vente" id="first_section">
            <h1 class="section-title text-linear-gradient">Offres en cours avec accès</h1>
            <div class="list-vente">
              <CardVente
                v-for="elem in ventesParticipation"
                v-bind:vente="elem.vente"
              ></CardVente>
              <div class="card see-all" v-if="ventesParticipation.length > 5">
                <button>
                  Voir toutes les ventes <span class="arrow">></span>
                </button>
              </div>
            </div>
          </section>
          <section class="section_vente" v-if="ventes != null && ventes != false && (ventesParticipation != false)" :id="(ventesParticipation == null) ? 'first_section' : ''">
            <h1 class="section-title text-linear-gradient">Offres en cours</h1>
            <div class="list-vente">
              <CardVente
                v-for="elem in ventes"
                v-bind:vente="elem.vente"
              ></CardVente>
              <div class="card see-all" v-if="ventes.length > 5">
                <button>
                  Voir toutes les ventes <span class="arrow">></span>
                </button>
              </div>
            </div>
          </section>
          <section class="section_vente" v-if="(ventesForthcoming != null && ventesForthcoming != false) && (ventesParticipation != false && ventes != false)" :id="(ventesParticipation == null && ventes == null) ? 'first_section' : ''">
            <h1 class="section-title text-linear-gradient">Offres à venir</h1>
            <div class="list-vente">
              <CardVente
                v-for="elem in ventesForthcoming"
                v-bind:vente="elem.vente"
                v-bind:forthcoming="true"
              ></CardVente>
              <div class="card see-all" v-if="ventesForthcoming.length > 5">
                <button>
                  Voir toutes les ventes <span class="arrow">></span>
                </button>
              </div>
            </div>
          </section>
          <section class="section_vente no_result" v-if="ventesParticipation === null && ventes === null && ventesForthcoming === null">
            <p>Malheureusement il n'y a aucune vente actuelle ou à venir avec les filtres utilisés. Veuillez changer vos filtres pour voir d'autres ventes Autoriko.</p>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

//import VenteParticipationPreview from '@/components/VentesPanel/VenteParticipationPreview.vue'
import CardVente from '@/components/VentesPanel/CardVente.vue'
import SeparationBarMarques from '@/components/MAIN/separation_bar_marques.vue'
import axios from 'axios'
import $ from 'jquery'

export default {
  name: 'VentesPanel',
  components:{
    CardVente,
    SeparationBarMarques
  },
  data() {
    return {
      isConnected: false,
      ventes: false,
      ventesForthcoming: false,
      ventesParticipation: false,
      ventesCategory: false,
      ventesTransmission: false,
      ventesEnergy: false,
      tabCategoryID: []
    }
  },
  methods: {
    init(){
      this.loadData()
    },
    loadData(){
      let category_id = null
      if(this.$route.query.category){
        let category_name = this.$route.query.category
        if(this.tabCategoryID[category_name]){
          category_id = this.tabCategoryID[category_name]
          this.ventesCategory = this.$route.query.category
        }
      }
      if(this.$route.query.transmission){
        this.ventesTransmission = this.$route.query.transmission
      }
      if(this.$route.query.energy){
        this.ventesEnergy = this.$route.query.energy
      }
      if(this.isConnected == true){
        api.get('/account/ventes', {params: { withCar: true, size: 6, category: category_id, transmission: this.ventesTransmission, energy: this.ventesEnergy } }).then(response => {
          if(response.data.ventes.length > 0)
            this.ventesParticipation = response.data.ventes
          else
            this.ventesParticipation = null
        }).catch(error => {
          alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        })
      }else{
        this.ventesParticipation = null
      }

      api.get('/ventes', {params: { withCar: true, size: 6, category: category_id, transmission: this.ventesTransmission, energy: this.ventesEnergy } }).then(response => {
        if(response.data.ventes.length > 0)
          this.ventes = response.data.ventes
        else
          this.ventes = null
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })

      api.get('/ventes', {params: { withCar: true, forthcoming: true, size: 6, category: category_id, transmission: this.ventesTransmission, energy: this.ventesEnergy } }).then(response => {
        if(response.data.ventes.length > 0)
          this.ventesForthcoming = response.data.ventes
        else
          this.ventesForthcoming = null
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    changeCategory(category){
      this.ventes = false
      this.ventesForthcoming = false
      if(this.isConnected)
        this.ventesParticipation = false

      if(this.ventesCategory == category){
        this.ventesCategory = null
      }else{
        this.ventesCategory = category
      }
      this.changeQuery()
    },
    changeTransmission(filter_value){
      this.ventes = false
      this.ventesForthcoming = false
      if(this.isConnected)
        this.ventesParticipation = false

      if(this.ventesTransmission == filter_value){
        this.ventesTransmission = null
      }else{
        this.ventesTransmission = filter_value
      }
      this.changeQuery()
    },
    changeEnergy(filter_value){
      this.ventes = false
      this.ventesForthcoming = false
      if(this.isConnected)
        this.ventesParticipation = false

      if(this.ventesEnergy == filter_value){
        this.ventesEnergy = null
      }else{
        this.ventesEnergy = filter_value
      }
      this.changeQuery()
    },
    changeQuery (){
      let query = new Object()
      if(this.ventesCategory != false)
        query.category = this.ventesCategory
      if(this.ventesTransmission != false)
        query.transmission = this.ventesTransmission
      if(this.ventesEnergy != false)
        query.energy = this.ventesEnergy
      //query.km_min = '1000'
      this.$router.push({query: { ...query }})
   }
  },
  watch: {
    '$route.query': function(){
      if(this.$route.name == 'VentesPanel'){
        this.ventesCategory = false
        this.ventesTransmission = false
        this.ventesEnergy = false
        this.init()
      }
    }
  },
  created(){
    if(this.$store.state.user && this.$store.state.userToken){
      this.isConnected = true
    }else{
      this.isConnected = false
    }

    this.tabCategoryID['compact'] = 1
    this.tabCategoryID['coupe'] = 2
    this.tabCategoryID['4x4'] = 3
    this.tabCategoryID['berline'] = 4
    this.tabCategoryID['cabriolet'] = 5
    if(this.$route.query.category){
      this.ventesCategory = this.$route.query.category
    }
    if(this.$route.query.transmission){
      this.ventesTransmission = this.$route.query.transmission
    }
    if(this.$route.query.energy){
      this.ventesEnergy = this.$route.query.energy
    }
  },
  updated() {
    this.$nextTick(() => {
      if(this.$route.hash && document.querySelector(this.$route.hash)){
        let topOfElement = document.querySelector(this.$route.hash).offsetTop;
        window.scroll({ top: topOfElement, behavior: "smooth" });
      }
    })
  },
  mounted(){
    this.init()
  }
}
</script>

<style scoped src="@/assets/css/pages/ventes-panel/main.css"></style>
<style scoped src="@/assets/css/pages/ventes-panel/card-vente.css"></style>

<style scoped lang="scss">
  .section_vente.no_result{
    padding: .8rem;
    background-color: #ffc107;
    border-radius: 5px;
    p{
      margin: 0;
      font-family: 'Montserrat';
      font-weight: 500;
      font-size: .9rem;
      color: #ffffff;
    }
  }
</style>

<style lang="scss">
  .list-vente{
    @media (min-width: 1400px) and (max-width: 1500px) {
      grid-gap: 14px !important;
    }
  }

  .ventes-panel-card-vente{
    @import "@/assets/css/pages/ventes-panel/card-vente";
  }

  .filter li{
    transition: background-color 0.2s;
    img{
      fill: #3c3c3b;
    }
    &.selected{
      background: linear-gradient(90deg, #aa1abb, #0552fa) !important;
      img{
        filter: invert(1);
      }
      p{
        color: #ffffff;
      }
    }
  }

  .block_ventes{
    min-width: 70%;
  }
</style>
