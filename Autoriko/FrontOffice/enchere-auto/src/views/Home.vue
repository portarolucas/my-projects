<template>
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
    <section class="section_1">
      <div class="align-center">
        <div class="title">
          <div class="left">
            <p class="pink">Votre prochaine voiture</p>
            <p class="blue">à partir de</p>
          </div>
          <div class="right">
            <p>1€</p>
          </div>
        </div>

        <div class="desc">
          <h3>Toutes nos voitures sont :</h3>
          <ul>
            <li>
              <div class="img-container">
                <img src="@/assets/img/pages/home/SECTION_1/LOGO/expertisee.png" alt="Expertisées" />
              </div>
              <p>Expertisées</p>
            </li>
            <li>
              <div class="img-container">
                <img src="@/assets/img/pages/home/SECTION_1/LOGO/garantie.png" alt="Garanties" />
              </div>
              <p>Garanties 6 mois</p>
            </li>
            <li>
              <div class="img-container">
                <img src="@/assets/img/pages/home/SECTION_1/LOGO/ct.png" alt="Controle technique" />
              </div>
              <p>Contrôle Technique de - 1 mois</p>
            </li>
            <li>
              <div class="img-container">
                <img src="@/assets/img/pages/home/SECTION_1/LOGO/livrees.png" alt="Livrées" />
              </div>
              <p>Livrées gratuitement à votre domicile*</p>
            </li>
          </ul>
        </div>

        <div class="btns-panel">
          <router-link to="/ventes_panel">
            <button v-if="isConnected" class="faire-offre">Accéder aux ventes</button>
            <button v-else class="faire-offre">Choisir ma voiture</button>
          </router-link>
          <p v-if="isConnected" class="recharger-compte">Recharger mon compte</p>
        </div>

        <img class="img-car" src="@/assets/img/pages/home/SECTION_1/peugoet.png" />

        <div class="vu-dans">
          <p>vu dans :</p>
          <div class="img-container">
            <img src="@/assets/img/pages/home/SECTION_1/VU_DANS_LOGO/forbes.png" alt="Forbes" />
            <img src="@/assets/img/pages/home/SECTION_1/VU_DANS_LOGO/automoto.png" alt="Auto moto" />
            <img src="@/assets/img/pages/home/SECTION_1/VU_DANS_LOGO/auto_plus.png" alt="Auto plus" />
            <img src="@/assets/img/pages/home/SECTION_1/VU_DANS_LOGO/petit_fute.png" alt="Petit fute" />
            <img src="@/assets/img/pages/home/SECTION_1/VU_DANS_LOGO/auto_journal.png" alt="Auto journal" />
          </div>
        </div>
        <div class="livraison-offerte">
          <p>* Livraison Offerte en France métropolitaine, Suisse, Belgique et Luxembourg jusqu’au 23/12/2021</p>
        </div>
      </div>
    </section>
    <SeparationBarMarques></SeparationBarMarques>
    <section class="align-center section_3">
      <div class="filter">
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
      <div class="list-vente">
          <CardVente
            v-for="elem in ventes"
            v-bind:vente="elem.vente"
          ></CardVente>
        <div class="card see-all">
          <router-link to="/ventes_panel">
            <button>
              Voir toutes les ventes <span class="arrow">></span>
            </button>
          </router-link>
        </div>
      </div>
    </section>
    <div class="separation-bar separation-bar-ventes align-center">
      Les avantages autoriko.com
    </div>
    <section class="align-center section_4">
      <div class="avantage-top">
        <div class="left">
          <div class="desc">
            <p>
              PRIX MOYEN PAYE
              <br>PAR L'ACHETEUR <span class="small">( par type de service )</span>
            </p>
          </div>
          <div class="schema-grid">
            <div class="block-bar">
              <div class="rectangle-container">
                <div class="rounded-rectangle colored"></div>
              </div>
              <div class="rectangle-container">
                <div class="rounded-rectangle"></div>
              </div>
              <div class="rectangle-container">
                <div class="rounded-rectangle"></div>
              </div>
              <div class="rectangle-container">
                <div class="rounded-rectangle"></div>
              </div>
            </div>
            <div class="block-libelle">
              <img src="@/assets/img/LOGO/logo.png" alt="Autoriko" />
              <h3>Vente entre particuliers</h3>
              <h3>Achat chez un professionnel</h3>
              <h3>Vente classique</h3>
            </div>
          </div>
        </div>
        <div class="right">
          <div class="line">
            <img src="@/assets/img/pages/home/SECTION_4/right/1.png"/>
            <p>NOS VOITURES SONT NÉGOCIÉES PAR NOS EXPERTS À DES PRIX IMBATTABLES.</p>
          </div>
          <div class="line">
            <img src="@/assets/img/pages/home/SECTION_4/right/2.png"/>
            <p>AUTORIKO SE REMUNERE SUR LES FRAIS DE PARTICIPATIONS DES ENCHÈRISSEURS.</p>
          </div>
          <div class="line">
            <img src="@/assets/img/pages/home/SECTION_4/right/3.png"/>
            <p>NOUS N’AVONS DONC AUCUN INTERET À GONFLER LE PRIX DE VOTRE FUTURE VOITURE, VOUS ASSURANT AINSI LE MEILLEUR PRIX POSSIBLE.</p>
          </div>
        </div>
      </div>
      <div class="satisfait-rembourser">
        <p>
          SATISFAIT OU REMBOURSÉ<br>
          <span class="small">14 JOURS DE RETRACTATION APRÈS ACHAT DU VÉHICULE</span>
        </p>
      </div>
      <div class="arguments-container">
        <div class="argument img-text">
          <div class="image-argument-shadow">
            <div class="image-argument" :style="{ 'background': 'no-repeat url(' + require('@/assets/img/pages/home/SECTION_4/content/without-effect/1.png') + ')', 'background-size': 'cover'}"></div>
          </div>
          <div class="white-bg">
            <div class="text">
              <h1 class="title">Tarif unique de 19,90€TTC de frais de participation</h1>
              <p class="desc">This is some extra text tu argue your specification.This is some extra text tu argue your specification.This is some extra text tu argue your specification.</p>
            </div>
          </div>
        </div>
        <div class="argument text-img">
          <div class="image-argument-shadow">
            <div class="image-argument" :style="{ 'background': 'no-repeat url(' + require('@/assets/img/pages/home/SECTION_4/content/without-effect/2.png') + ')', 'background-size': 'cover'}"></div>
          </div>
          <div class="white-bg">
            <div class="text">
              <h1 class="title">aucun prix de reserve toutes nos ventes commencent a 1 eur</h1>
              <p class="desc">This is some extra text tu argue your specification.This is some extra text tu argue your specification.</p>
            </div>
          </div>
        </div>
        <div class="argument img-text">
          <div class="image-argument-shadow">
            <div class="image-argument" :style="{ 'background': 'no-repeat url(' + require('@/assets/img/pages/home/SECTION_4/content/without-effect/3.png') + ')', 'background-size': 'cover'}"></div>
          </div>
          <div class="white-bg">
            <div class="text">
              <h1 class="title">Livraison gratuite</h1>
              <p class="desc">This is some extra text tu argue your specification.This is some extra text tu argue your specification.This is some extra text tu argue your specification.</p>
            </div>
          </div>
        </div>
        <div class="argument text-img">
          <div class="image-argument-shadow">
            <div class="image-argument" :style="{ 'background': 'no-repeat url(' + require('@/assets/img/pages/home/SECTION_4/content/without-effect/4.png') + ')', 'background-size': 'cover', 'background-position-x': '15%'}"></div>
          </div>
          <div class="white-bg">
            <div class="text">
              <h1 class="title">100% Securise</h1>
              <p class="desc">This is some extra text tu argue your specification.This is some extra text tu argue your specification.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>

import CardVente from '@/components/Home/CardVente.vue'
import SeparationBarMarques from '@/components/MAIN/separation_bar_marques.vue'
import axios from 'axios'

export default {
  name: 'Home',
  components:{
    CardVente,
    SeparationBarMarques
  },
  data(){
    return {
      ventes: null,
      isConnected: false
    }
  },
  methods: {
    init(){
      if(this.isConnected){
        api.get('/account').then(response => {
          console.log(response)
        }).catch(error => {
          console.log((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        })
      }
      api.get('/ventes?size=5').then(response => {
        this.ventes = response.data.ventes
      }).catch(error => {
        console.log((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    }
  },
  created(){
    if(this.$store.state.user && this.$store.state.userToken){
      this.isConnected = true
    }else{
      this.isConnected = false
    }
  },
  mounted(){
    this.init()
  }
}
</script>

<style scoped src="@/assets/css/pages/home/main.css"></style>
<style scoped src="@/assets/css/pages/home/card-vente.css"></style>

<style lang="scss">
  .home-card-vente{
    @import "@/assets/css/pages/home/card-vente";
  }
</style>
