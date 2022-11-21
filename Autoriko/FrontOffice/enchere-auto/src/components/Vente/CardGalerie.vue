<template>
  <span class="vente-card-galerie">
    <div v-if="show_modal_galerie" class="modal-galerie">
      <div class="modal-block" @click="close_modal()">
        <button @click.stop="close_modal()" type="button" class="close">X</button>
        <img @click.stop="" class="actual-picture" :src="this.galerie.photos[0].photo.link" />
        <div class="others-pics-block">
          <img @click.stop="togglePicture" v-for="elem in this.galerie.photos" :src="elem.photo.link" />
        </div>
      </div>
    </div>
    <div @click="open_modal()" class="block-galerie">
      <div class="img" :style="{ 'background-image' : 'url(' + this.galerie.photos[0].photo.link + ')'}"></div>
      <p>{{ this.galerie.name }}</p>
    </div>
  </span>
</template>

<script>

import $ from 'jquery'

export default{
  props: ['galerie'],
  data(){
    return {
      modalGalerieBlock: null,
      show_modal_galerie: false
    }
  },
  methods: {
    open_modal(){
      $("body").addClass("modal-open");
      this.show_modal_galerie = true
    },
    close_modal(){
      $("body").removeClass("modal-open");
      this.show_modal_galerie = false
    },
    togglePicture(event){
      let pictureSrc = $(event.target).prop('src')
      let actualPicture = $('.modal-block .actual-picture')[0];
      $(actualPicture).prop('src', pictureSrc)
    }
  },
  computed: {

  },
  mounted(){
    this.modalGalerieBlock = document.querySelectorAll('.modal-galerie')[0]
  }
}
</script>

<style lang="scss">

//TODO changé par le vrai fichier
.block-photo-additionnelle{
  margin-top: 2rem * 2;

  h1{
    margin: 0;
    margin-bottom: 2rem;
    font-weight: 600;
    font-size: 1.5rem;
    text-transform: uppercase;
  }
  .block-galeries{
    display: flex;
    justify-content: left !important;//TODO modifier le scss
    align-items: flex-start;
    flex-wrap: nowrap;
    .block-galerie{
      margin-right: 2rem;
      .img{
        display: block;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        height: 8rem;
        width: 13rem;
        border: 3px solid white;
        -webkit-box-shadow: 0 0px 8px 5px rgb(0 0 0 / 15%);
        box-shadow: 0 0px 8px 5px rgb(0 0 0 / 15%);
        cursor: pointer;
      }
      p{
        margin: 0;
        margin-top: 1rem;
        display: block;
        text-align: center;
      }
    }
  }

  .modal-galerie{
    position: fixed;
    background-color: rgba(0,0,0,0.9);
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    .modal-block{
      display: flex;
      flex-direction: column;
      align-items: center;
      align-content: center;
      justify-content: center;
      height: 100%;

      button.close{
        position: absolute;
        top: 2rem;
        right: 2rem;
        height: 3rem;
        width: 3rem;
        border: 0;
        color: white;
        background-color: rgba(0,0,0,0.8);
        cursor: pointer;
      }
      img.actual-picture{
        height: 65vh;
        display: block;
      }
      .others-pics-block{
        height: 15vh;
        margin-top: 1rem;
        display: flex;
        justify-content: space-around;
        flex-wrap: nowrap;
        img{
          display: block;
          height: 100%;
          margin-left: .5rem;
          margin-right: .5rem;
          cursor: pointer;

          &:hover{
            opacity: 0.7;
          }
        }
      }
    }
  }
}
</style>
