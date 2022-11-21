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
    <section>
      <div>
        <div class="container">
          <div>
            <h1>Connexion</h1>
            <hr>
            <div>
              <form @submit.prevent="login" action="">
                <div class="field">
                  <label for="" class="label">Votre adresse mail</label>
                  <div>
                    <input v-model="email" type="email" class="input" placeholder="Adresse mail" required>
                  </div>
                </div>
                <div class="field">
                  <label for="" class="label">Votre mot de passe</label>
                  <div>
                    <input v-model="password" type="password" class="input" placeholder="Mot de passe" required>
                  </div>
                </div>
                <div class="field">
                  <label for="remember_me" class="checkbox">
                    <input id="remember_me" type="checkbox" v-model="rememberMe">
                    Se souvenir de moi
                  </label>
                </div>
                <div class="field">
                  <br>
                  <button>
                    Se connecter
                  </button>
                </div>
                <hr>
                <div class="field" v-if="askForgotPassword">
                  <router-link :to="{ name: 'ForgotPassword' }">Vous avez oublié votre mot de passe?</router-link>
                </div>
                <div class="field">
                  <router-link :to="{ name: 'Signup' }">Pas encore de compte ? s'inscrire</router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>

export default{
  name: 'Signin',
  data() {
    return {
      email : '',
      password : '',
      rememberMe : true,
      numberAttempts : 0,
      askForgotPassword : false
    }
  },
  methods:{
    init(){
      if(this.$store.state.remember_email){
        this.email = this.$store.state.remember_email
        this.password = this.$store.state.remember_password
        this.askForgotPassword = this.$store.state.askForgotPassword
      }
    },
    login(){
      api.post('/signin', {
        'email' : this.email,
        'password' : this.password
      }).then(response => {
        this.$store.commit('setUser', response.data.user)
        this.$store.commit('setUserToken', response.data.token_xsrf)
        this.$store.commit('setAskForgotPassword', false)
        api.defaults.headers.common['X-XSRF-TOKEN'] = response.data.token_xsrf
        if(this.rememberMe){
          this.$store.commit('setRememberCredentials', {'email' : this.email, 'password' : this.password})
        }
        window.mitt.emit("connected")
        this.$router.push('/')
      }).catch(error => {
        if(error.response){
          alert('Impossible de se connecter. ' + error.response.data.message_status)
          this.numberAttempts++
          if(this.numberAttempts >= 5){
            this.askForgotPassword = true
            this.$store.commit('setAskForgotPassword', true)
          }
        }else{
          alert("Impossible de se connecter une erreur inconnue s'est produite. Veuillez actualiser la page et si le problème persiste contacter l'administrateur de l'application")
        }
      })
    }
  },
  watch: {
    rememberMe: function(val){
      if(val === false) this.$store.commit('notRememberUser')
    }
  },
  mounted(){
    this.init();
  }
}
</script>

<style>

</style>
