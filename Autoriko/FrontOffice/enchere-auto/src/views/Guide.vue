<template>
  <div class="main-content">
    <section class="section_1 align-center">
      <h1 class="title-page">Page de guide</h1>
      <p class="desc-page">Autoriko vous permet d'enchèrir en ligne, en toute sécurité et à partir d'1€ seulement !</p>
      <div class="block-guide">
        <img src="@/assets/img/pages/guide/SECTION_1/signup.svg" alt="" />
        <div class="content-text">
          <h3>Devenez membre Autoriko</h3>
          <p>Pour pouvoir surfer sur tout le site vous devez disposer d'un compte, celui-ci vous permetra par la suite d'accèder à une enchère et d'y participer pour vous offrir un véhicule à prix cassé !</p>
        </div>
      </div>
      <div class="block-guide right">
        <img src="@/assets/img/pages/guide/SECTION_1/door_access.svg" alt="" />
        <div class="content-text">
          <h3 class="title">Accèder à une enchère</h3>
          <p>
            Afin de participer à une enchère vous devez vous procurer un ticket de participation au prix de 19,90€ pour n'importe quelle enchère.
            <br><br>
            Ensuite vous serez libre de participer à cette enchère et de faire monter le prix en votre faveur !
          </p>
        </div>
      </div>
      <div class="block-guide">
        <img src="@/assets/img/pages/guide/SECTION_1/confirmed.svg" alt="" />
        <div class="content-text">
          <h3>Offre acquis</h3>
          <p>
            Une fois l'offre terminé, si vous l'avez acquis vous serez dans l'obligation pénale de procéder au paiment afin de valider votre acquisition.
          </p>
        </div>
      </div>
      <div class="block-guide right">
        <img src="@/assets/img/pages/guide/SECTION_1/validate.svg" alt="" />
        <div class="content-text">
          <h3>Confirmation par le staf</h3>
          <p>
            Notre équipe validera ensuite votre acquisition
          </p>
        </div>
      </div>
      <div class="block-guide">
        <img src="@/assets/img/pages/guide/SECTION_1/key_hand.svg" alt="" />
        <div class="content-text">
          <h3>Livraison à votre domicile</h3>
          <p>
            Jusqu'au 23 décembre 2021 on vous livre votre nouvelle voiture dans toutes la France métropolitaine, en Suisse, en Belgique et au Luxembourg !
            <br><br>
            Gagner votre enchère et Autoriko s'occupe de tout le reste, vous recevrez votre nouvelle voiture devant chez vous clé en main !
          </p>
        </div>
      </div>
    </section>
    <hr>
    <section class="section_2 align-center">
      <router-link to="/ventes_panel">
        <button class="faire-offre">Accéder aux ventes</button>
      </router-link>
      <router-link to="/contact">
        <p class="question">Vous avez une question ?</p>
      </router-link>
    </section>
  </div>
</template>

<script>

export default {
  name: 'Guide',
  data(){
    return {

    }
  }
}
</script>

<style scoped src="@/assets/css/pages/guide/main.css"></style>
