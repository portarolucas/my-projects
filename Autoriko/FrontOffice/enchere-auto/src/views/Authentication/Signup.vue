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
            <h3>Vos informations</h3>
            <hr>
            <div>
              <form @submit.prevent="signup" action="">
                <div class="field">
                  <label for="" class="label">Votre prénom</label>
                  <div>
                    <input v-model="firstname" type="text" class="input" placeholder="Prénom" required>
                  </div>
                </div>
                <div class="field">
                  <label for="" class="label">Votre nom</label>
                  <div>
                    <input v-model="lastname" type="text" class="input" placeholder="Nom" required>
                  </div>
                </div>
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
                  <label for="" class="label">Vérification du mot de passe</label>
                  <div>
                    <input v-model="password_verif" type="password" class="input" placeholder="Vérification mot de passe" required>
                  </div>
                </div>
                <br>
                <hr>
                <div class="field">
                  <p>Vous êtes :</p>
                  <button @click.prevent="changeRegisterType(0)" v-bind:class="[ type == 0 ? 'isSelected' : '' ]">
                    Particulier
                  </button>
                  |
                  <button @click.prevent="changeRegisterType(1)" v-bind:class="[ type == 1 ? 'isSelected' : '' ]">
                    Entreprise
                  </button>
                </div>
                <br>
                <hr>
                <div v-if="type == 1">
                  <h3>Information entreprise</h3>
                  <label for="" class="label">Raison sociale :</label>
                  <div>
                    <input v-model="name_entreprise" type="text" class="input" placeholder="Raison sociale" required>
                  </div>
                  <br>
                  <hr>
                </div>
                <div class="field">
                  <button>
                    S'inscrire
                  </button>
                </div>
                <hr>
                <div class="field">
                  <router-link :to="{ name: 'Signin' }">Déjà inscrit ? se connecter</router-link>
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
//if(isset($data['type']) && isset($data['firstname']) && isset($data['lastname']) && ($data['email']) && isset($data['password'])){
export default{
  name: 'Signin',
  data() {
    return {
      type : null,
      firstname : '',
      lastname : '',
      email : '',
      password : '',
      password_verif : '',
      name_entreprise : ''
    }
  },
  mixins: [

  ],
  methods:{
    signup(){
      if(this.type != null && this.firstname != '' && this.lastname != '' && this.email != '' && this.password != '' && this.password_verif != ''){
        if(this.password === this.password_verif){
          let data = {
            'type': this.type,
            'firstname': this.firstname,
            'lastname': this.lastname,
            'email': this.email,
            'password': this.password
          }
          if(this.type == 1)
            data.name_entreprise = this.name_entreprise
          api.post('/signup', data).then(response => {
            this.$store.commit('disconnectUser')
            this.$store.commit('setUser', response.data.user)
            this.$store.commit('setRememberCredentials', {'email' : this.email, 'password' : this.password})
            alert(response.data.message_status)
            this.$router.push('/signup_success')
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
    changeRegisterType(_type){
      if(_type == 0)
        this.type = 0
      else if(_type == 1)
        this.type = 1
    }
  }
}
</script>

<style scoped>
  .isSelected{
    background-color: green;
  }
</style>
