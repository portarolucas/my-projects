<template>
  <div class="main-content">
    <section class="section_1 align-center">
      <h1 class="title-page">Une question ? Contactez nous</h1>
      <p class="desc-page">
        N'hésitez pas à prendre contact avec nous pour toutes questions :<br>
        <br>
        - par mail à : <a href="mailto:autoriko@contact.fr" class="text-linear-gradient">autoriko@contact.fr</a><br>
        <br>
        - par téléphone au : <a href="tel:800 000 000" class="text-linear-gradient">800 000 000</a>

      </p>
      <div class="block-contact">
        <p class="desc">
          Vous pouvez également nous contacter via notre formulaire de contact, nous vous répondrons sous 48H !
        </p>
        <form @submit.prevent="sendMail" action="" class="form-contact">
          <div class="form-grp email">
            <label for="form-email">Adresse mail *</label>
            <input v-model="email" type="text" required id="form-email" placeholder="Votre adresse mail">
          </div>
          <div class="form-grp nom">
            <label for="form-nom">Nom</label>
            <input v-model="lastname" type="text" id="form-nom" placeholder="Votre nom">
          </div>
          <div class="form-grp prenom">
            <label for="form-prenom">Prénom</label>
            <input v-model="firstname" type="text" id="form-prenom" placeholder="Votre prénom">
          </div>
          <div class="form-grp telephone">
            <label for="form-telephone">Numéro de téléphone</label>
            <input v-model="phone_number" type="text" id="form-telephone" placeholder="Votre numéro de téléphone">
          </div>
          <div class="form-grp message">
            <label for="form-message">Message *</label>
            <textarea v-model="message" rows="5" minlength="5" required id="form-message" placeholder="Votre message"></textarea>
          </div>
          <p class="required_fields">* Champs obligatoires</p>
          <input type="submit" value="Envoyer">
        </form>
      </div>
    </section>
    <hr>
    <section class="section_2 align-center">
      <router-link to="/ventes_panel">
        <button class="faire-offre">Accéder aux ventes</button>
      </router-link>
      <router-link to="/guide">
        <p class="guide">Comment ça marche ?</p>
      </router-link>
    </section>
  </div>
</template>

<script>

export default {
  name: 'Contact',
  data(){
    return {
      email: '',
      lastname: '',
      firstname: '',
      phone_number: '',
      message: ''
    }
  },
  methods:{
    sendMail(){
      if(this.email != '' && this.message != ''){
        let data = {
          'message': this.message,
          'firstname': this.firstname,
          'lastname': this.lastname,
          'email': this.email,
          'phone_number': this.phone_number
        }
        api.post('/contact', data).then(response => {
          alert(response.data.message_status)
        }).catch(error => {
          alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        })
      }else{
        alert('Des champs sont manquant ou incomplet, veuillez réessayer.')
      }
    }
  }
}
</script>

<style scoped src="@/assets/css/pages/contact/main.css"></style>
