<template>
  <nav v-bind:class="{ 'nav-disconnected' : isConnected == false }" class="nav-header align-center">
    <router-link to="/">
      <img class="logo" src="@/assets/img/LOGO/logo.png" alt="Autoriko"/>
    </router-link>
    <ul class="menu">
      <li v-if="isConnected"><router-link to="/">ACCUEIL</router-link></li>
      <li v-if="isConnected"><router-link to="/ventes_panel">Ventes en cours</router-link></li>
      <li v-if="isConnected"><router-link to="/guide">Guide</router-link></li>
      <li class="hotline">
        <a v-if="site_info" href="tel:{{ site_info.informations.phone_number }}">
          <img class="logo_tel" src="@/assets/img/NAV/ICONS/hotline.png" />
          <div class="text">
            <div>Hotline</div>
            <div v-if="site_info" class="number">{{ site_info.phone_number }}</div>
          </div>
        </a>
      </li>
      <li v-if="isConnected && user">Bonjour {{ user.firstname }}</li>
      <li v-if="!isConnected">
        <button class="se-inscrire" @click.stop="open_modal_signup">S'inscrire !</button>
      </li>
      <li v-if="!isConnected">
        <router-link to="/signin"><p class="se-connecter">Se connecter</p></router-link>
      </li>
      <li v-if="isConnected" class="icons-btn">
        <a href="/conversations_panel" id="nav_conversation_link" data-count="" @click.stop.prevent="openMenu('conversation', '/conversations')" v-bind:class="{ 'selected' : menu_selected == 'conversation' }">
          <img src="@/assets/img/NAV/ICONS/message.png" />
        </a>
        <a href="#" id="nav_alert_link" data-count="" @click.stop.prevent="openMenu('alert', '/alertes')" v-bind:class="{ 'selected' : menu_selected == 'alert' }">
          <img src="@/assets/img/NAV/ICONS/bell.png" />
        </a>
        <a href="#" data-count="" @click.stop.prevent="openMenu('account')" v-bind:class="{ 'selected' : menu_selected == 'account' }">
          <img src="@/assets/img/NAV/ICONS/profil.png" />
        </a>
      </li>
    </ul>
  </nav>

  <!-- COMBAK: MADE & TAKE THIS IN NEW COMPONENT signup -->
  <div v-if="signup_modal && !isConnected" class="signup-modal">
    <div class="block-signup" v-click-outside="close_modal_signup">
      <div @click.stop="close_modal_signup" class="close-modal">
        X
      </div>
      <div v-if="signup_validate == false" class="left">
        <div @click="signup_modal_type = 'particulier'" v-bind:class="{ 'selected' : signup_modal_type == 'particulier' }" class="choose-particulier">
          <p>Je suis <span class="type-text-xl">un particulier</span></p>
        </div>
        <div @click="signup_modal_type = 'entreprise'" v-bind:class="{ 'selected' : signup_modal_type == 'entreprise' }" class="choose-entreprise">
          <p>Je représente <span class="type-text-xl">une entreprise</span></p>
        </div>
      </div>
      <div v-if="signup_validate == false" class="right">
        <h1>Inscription</h1>
        <div v-if="signup_modal_type == 'entreprise'" class="info-block">
          <label for="raison_social">Raison sociale *</label>
          <input v-model="signup_raison_social" required type="text" name="raison_socials" placeholder="Raison sociale de votre entreprise" />
        </div>
        <div class="info-block">
          <label for="firstname">Prénom *</label>
          <input v-model="signup_firstname" required type="text" name="firstname" placeholder="Votre prénom" />
        </div>
        <div class="info-block">
          <label for="lastname">Nom *</label>
          <input v-model="signup_lastname" required type="text" name="lastname" placeholder="Votre nom" />
        </div>
        <div class="info-block">
          <label for="email">Adresse mail *</label>
          <input v-model="signup_email" required type="text" name="email" placeholder="Votre adresse mail" />
        </div>
        <div class="info-block">
          <label for="password">Mot de passe *</label>
          <input v-model="signup_password" required type="password" name="password" placeholder="Votre mot de passe" />
        </div>
        <div class="info-block">
          <label for="verif_password">Veuillez ressaisir votre mot de passe *</label>
          <input v-model="signup_password_verify" required type="password" name="verif_password" placeholder="Vérification mot de passe" />
        </div>
        <button @click="signup" type="button" class="se-inscrire">S'inscrire</button>
        <router-link @click="close_modal_signup" to="/signin">Déjà un compte ? Se connecter</router-link>
      </div>
      <div class="form-signup-validate" v-if="signup_validate == true">
        <h1>Bienvenue sur <span class="text-linear-gradient">Autoriko !</span></h1>
        <p>
          Vous allez recevoir un lien de confirmation à votre adresse : <u>{{ user.email }}</u><br>
          <br>
          Veuillez <span class="text-linear-gradient">confirmer ce lien</span> qui vous a été envoyé, et ainsi vous pourrez vous connecter à votre compte.
        </p>
        <h3>Toute l'équipe Autoriko vous souhaite la bienvenue !</h3>
        <hr>
        <h4>Vous avez confirmé votre compte ? Veuillez vous connecter : <router-link :to="{ name: 'Signin' }"><span @click="close_modal_signup" class="text-linear-gradient">ici</span></router-link></h4>
      </div>
    </div>
  </div>

  <div v-if="isConnected" class="menu_block conversations_block" v-click-outside="closeMenuConversation" v-bind:class="{ 'selected' : menu_selected == 'conversation' }">
    <MenuConversation></MenuConversation>
  </div>
  <div v-if="isConnected" class="menu_block alerts_block" v-click-outside="closeMenuAlert" v-bind:class="{ 'selected' : menu_selected == 'alert' }">
    <MenuAlert></MenuAlert>
  </div>
  <div v-if="isConnected" class="menu_block account_block" v-click-outside="closeMenuAccount" v-bind:class="{ 'selected' : menu_selected == 'account' }">
    <MenuAccount></MenuAccount>
  </div>

  <div class="main-section">
    <!--##########-->
    <!-- APP Page -->
    <router-view :key="$route.path"/>
    <!--##########-->
    <!--##########-->
  </div>

  <footer class="align-center">
    <div class="left">
      <div>
        <router-link to="/">
          <img class="logo" src="@/assets/img/LOGO/logo.png" alt="Autoriko"/>
        </router-link>
      </div>
      <p class="localisation">
        18 rue de la ruelle
        <br>75001 Paris France
      </p>
      <div class="copyright-nav">
        <p>
          Autoriko © 2021 - All rights reserved
        </p>
        <ul class="footer-nav">
          <li><router-link to="/contact">Contact</router-link></li><li>|</li>
          <li><a href="#">A propos</a></li><li>|</li>
          <li><a href="#">Plan du site</a></li>
        </ul>
      </div>
    </div>
    <div class="right">
      <button v-if="!isConnected" @click.stop="open_modal_signup" class="signup-btn">Inscrivez-vous</button>
      <div class="get-app">
        <a href="#">
          <img src="@/assets/img/FOOTER/get-app-ios.png" alt="iOS Application"/>
        </a>
        <a href="#">
          <img src="@/assets/img/FOOTER/get-app-android.png" alt="Android Application"/>
        </a>
      </div>
    </div>
  </footer>
</template>

<script>
import $ from 'jquery';
import MenuAlert from '@/components/MAIN/menu_alert.vue'
import MenuConversation from '@/components/MAIN/menu_conversation.vue'
import MenuAccount from '@/components/MAIN/menu_account.vue'

export default {
  name: 'App',
  components:{
    MenuAlert,
    MenuConversation,
    MenuAccount
  },
  data(){
    return {
      isConnected: false,
      user: null,
      site_info: null,
      signup_modal: false,
      signup_modal_type: 'particulier',
      signup_firstname: '',
      signup_lastname: '',
      signup_email: '',
      signup_raison_social: '',
      signup_password: '',
      signup_password_verify: '',
      signup_validate: false,
      menu_selected: false,
      count_alert: 0,
      count_conversation: 0,
      notificationRefresh: false
    }
  },
  created() {
    window.addEventListener("resize", this.setMainContentMinHeight)
  },
  beforeUnmount: function () {
    window.removeEventListener("resize", this.setMainContentMinHeight)
    console.log('INTERVAL (notification) : SUPPRIMÉ')// COMBAK:  delete this
    clearInterval(this.notificationRefresh);
  },
  methods:{
    init(){
      this.setMainContentMinHeight()
      api.get('/site/informations').then(response => {
        this.site_info = response.data.informations
        this.$store.commit('setSiteInfo', response.data.informations)
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
      if(this.isConnected && this.notificationRefresh == false){
        this.notificationRefresh = setInterval(() => {
          console.log('INTERVAL (notif refresh (alert & conv))')// COMBAK: delete this
          window.mitt.emit('update_menu_alert')
          window.mitt.emit('update_menu_conversation')
        }, 5000)
      }
    },
    setMitter(){
      window.mitt.on('open_modal_signup', () => {
        this.open_modal_signup()
      });

      window.mitt.on("alertesReceipt", (count) => {
        console.log(count)
        if(count < 1){
          count = ""
        }
        $("#nav_alert_link").attr('data-count', count)
      });

      window.mitt.on("conversationsReceipt", (count) => {
        console.log(count)
        if(count < 1){
          count = ""
        }
        $("#nav_conversation_link").attr('data-count', count)
      });

      //L'émeteur "connection"
      window.mitt.on("connected", () => {
        this.user = this.$store.state.user
        this.isConnected = true
        this.notificationRefresh = setInterval(() => {
          console.log('INTERVAL (notif refresh (alert & conv))')// COMBAK: delete this
          window.mitt.emit('update_menu_alert')
          window.mitt.emit('update_menu_conversation')
        }, 5000)
      });

      //L'émeteur "disconnect"
      window.mitt.on("disconnected", () => {
        this.menu_selected = false
        this.isConnected = false
        console.log('INTERVAL (notification) : SUPPRIMÉ')// COMBAK: delete this
        clearInterval(this.notificationRefresh);
        this.notificationRefresh = false
        api.post('/disconnect').then(response => {
          this.$store.commit('disconnectUser')
          this.$router.push('/signin')
        }).catch(error => {
          // COMBAK:
          //  alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        })
      });
    },
    signup(){
      // COMBAK: MADE & TAKE THIS IN NEW COMPONENT signup
      if(this.signup_modal_type != null && this.signup_firstname != '' && this.signup_lastname != '' && this.signup_email != '' && this.signup_password != '' && this.signup_password_verify != ''){
        if(this.signup_password === this.signup_password_verify){
          let data = {
            'type': this.signup_modal_type,
            'firstname': this.signup_firstname,
            'lastname': this.signup_lastname,
            'email': this.signup_email,
            'password': this.signup_password
          }
          if(this.signup_modal_type == 'entreprise')
            data.name_entreprise = this.signup_raison_social
          api.post('/signup', data).then(response => {
            this.$store.commit('disconnectUser')
            this.$store.commit('setUser', response.data.user)
            this.$store.commit('setRememberCredentials', {'email' : this.signup_email, 'password' : this.signup_password})
            this.user = response.data.user
            this.signup_validate = true
          }).catch(error => {
            alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
          })
        }else{
          alert('Les mots de passe ne correspondent pas, veuillez réessayer.')
        }
      }else{
        alert('Des champs sont manquant ou incomplet, veuillez réessayer.')
      }
    },
    disconnect(){
      window.mitt.emit('disconnected')
      this.isConnected = false
    },
    setMainContentMinHeight(){
      let heightNav = $('nav')[0].offsetHeight
      let heightFooter = $('footer')[0].offsetHeight
      $('.main-content').removeAttr("style")
      $('.main-content').css('min-height', 'calc(100vh - ' + (heightNav + heightFooter) + 'px)')
    },
    open_modal_signup(){
      $("body").addClass("modal-open");
      this.signup_modal = true
    },
    close_modal_signup(){
      if(this.signup_modal != false){
        $("body").removeClass("modal-open");
        this.signup_modal = false
      }
    },
    openMenu(name, route = false){
      if(this.menu_selected != name){
        if(this.menu_selected == 'alert'){
          window.mitt.emit('set_alert_read')
        }
        this.menu_selected = name
      }else{
        //on part sur le lien
        if(route){
          this.$router.push(route)
          this.menu_selected = false
        }
      }
    },
    closeMenuAlert(){
      if(this.menu_selected == 'alert'){
        window.mitt.emit('set_alert_read')
        this.menu_selected = false
      }
    },
    closeMenuConversation(){
      if(this.menu_selected == 'conversation'){
        this.menu_selected = false
      }
    },
    closeMenuAccount(){
      if(this.menu_selected == 'account'){
        this.menu_selected = false
      }
    }
  },
  watch: {
    '$route': function(){
      this.setMainContentMinHeight()
      if(this.$store.state.user && this.$store.state.userToken){
        api.defaults.headers.common['X-XSRF-TOKEN'] = this.$store.state.userToken
        this.isConnected = true
        this.user = this.$store.state.user
        this.site_info = this.$store.state.site_info
      }else{
        this.isConnected = false
      }
    }
  },
  created(){
    if(this.$store.state.user && this.$store.state.userToken){
      this.isConnected = true
      api.defaults.headers.common['X-XSRF-TOKEN'] = this.$store.state.userToken
    }else{
      this.isConnected = false
    }
  },
  mounted(){
    this.init()
    this.setMitter()
  }
}

</script>

<style lang="scss">
  @import './assets/css/MAIN/header-nav.css';
  @import './assets/css/MAIN/background.css';
  @import './assets/css/MAIN/utils.css';
  @import './assets/css/MAIN/footer.css';
  @import './assets/css/MAIN/signup_modal.css';
  @import './assets/css/MAIN/menu_component.css';
</style>

<style lang="scss">
  html {
    font-size: 100%;
  }

  .main-section{
    width: 100%;
  }

  body.modal-open {
    overflow: hidden;
  }

  .menu_block{
    display: none;

    &.selected{
      display: block;
    }
  }

  .signup-modal .left .type-text-xl{
    display: block;
    font-size: 1.3em;
  }

  .form-signup-validate{
    background-color: #fff;
    padding: 3rem;
    font-family: Montserrat;
    color: #000;
    width: 100%;
    height: 100%;
    a{
      text-decoration: underline;
    }

    p{
      font-weight: 500;
    }
  }
</style>
