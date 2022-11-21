<template>
  <span>
    <h1>Votre compte</h1>
    <div class="menu_container">
      <div class="menu_row">
        <p><b>Détails du compte</b></p>
      </div>
      <hr>
      <div class="menu_row">
        <p><b>Confidentialité</b></p>
      </div>
      <hr>
      <div class="menu_row">
        <p><b>Préférences utilisateur</b></p>
      </div>
      <hr>
      <div class="menu_row" @click="disconnect">
        <p><b>Se déconnecter</b></p>
      </div>
    </div>
  </span>
</template>

<script>


export default{
  data(){
    return {

    }
  },
  methods: {
    init(){

    },
    disconnect(){
      window.mitt.emit('disconnected')
    }
  },
  mounted(){

  }
}
</script>

<style lang="scss" scoped>
  .menu_row {
    cursor: pointer;
    p{
      b{
        font-weight: 500;
      }
    }
  }
</style>
