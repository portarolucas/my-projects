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
            <div>
              <h1>Bienvenue sur Autoriko !</h1>
              <p>
                Vous allez recevoir un lien de confirmation à votre adresse : <u>{{ user.email }}</u><br>
                Veuillez confirmer ce lien qui vous a été envoyé, et ainsi vous pourrez vous connecter à votre compte.
              </p>
              <h4>Toute l'équipe Autoriko vous souhaite la bienvenue !</h4>
              <hr>
              <h6>Vous avez confirmé votre compte ? Veuillez vous connecter : <router-link :to="{ name: 'Signin' }">ici</router-link></h6>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
//if(isset($data['type']) && isset($data['firstname']) && isset($data['lastname']) && ($data['email']) && isset($data['password'])){
export default{
  name: 'SignupSuccess',
  data() {
    return {
      user : null
    }
  },
  created(){
    this.user = this.$store.state.user
  }
}
</script>

<style scoped>

</style>
