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
            <h1>Vous avez oublié votre mot de passe ?</h1>
            <h4>Faites une demandes de réinitialisation de mot de passe par email.</h4>
            <hr>
            <div>
              <form @submit.prevent="requestNewPassword" action="">
                <div class="field">
                  <label class="label">Veuillez entrer votre adresse mail</label>
                  <div>
                    <input v-model="email" type="email" class="input" placeholder="Adresse mail" required>
                  </div>
                </div>
                <div class="field">
                  <br>
                  <button>Envoyer</button>
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
  name: 'ForgotPassword',
  data() {
    return {
      email : ''
    }
  },
  methods:{
    requestNewPassword(){
      api.put('/account/password', {
        'email' : this.email
      }).then(response => {
        alert(response.data.message_status)
        this.$store.commit('setAskForgotPassword', false)
        this.$store.commit('setRememberCredentials', {'email' : this.email, 'password' : ''})
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    }
  }
}
</script>

<style scoped>

</style>
