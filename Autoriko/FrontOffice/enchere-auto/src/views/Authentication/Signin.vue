<template>
  <div class="main-content" :style="{ 'background-image' : 'url(' + require('@/assets/img/pages/signin/BG/background.jpg') + ')'}">
    <section class="section_1">
      <form @submit.prevent="login" action="">
        <div class="block-login">
          <h1>Connexion</h1>
          <input v-model="email" required type="email" placeholder="Adresse mail" />
          <input v-model="password" required type="password" placeholder="Mot de passe" />
          <button type="submit" class="se-connecter">Se connecter</button>
          <hr>
          <router-link v-if="askForgotPassword" :to="{ name: 'ForgotPassword' }">Vous avez oublié votre mot de passe?</router-link>
          <a @click.prevent.stop="open_modal_signup" style="cursor: pointer;">Pas encore de compte ? s'inscrire</a>
        </div>
      </form>
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
    open_modal_signup(){
      window.mitt.emit('open_modal_signup')
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
  created(){
    if(this.$store.state.remember_email){
      this.email = this.$store.state.remember_email
      this.password = this.$store.state.remember_password
      this.askForgotPassword = this.$store.state.askForgotPassword
    }
  }
}
</script>
<style scoped src="@/assets/css/pages/signin/main.css"></style>
