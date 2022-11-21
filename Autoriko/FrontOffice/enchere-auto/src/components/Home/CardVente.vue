<template>
  <span class="home-card-vente">
    <router-link :to="{ name: 'Vente', params: { uuid: vente.uuid } }">
      <div class="card car">
        <img :src="vente.link_thumbnail" />
        <h1>{{ vente.title }}</h1>
        <div class="desc">
          <div class="left">
            <h3>Prix actuel</h3>
            <p>{{ vente.price }} eur</p>
          </div>
          <div class="separation-bar-desc"></div>
          <div class="right">
            <h3>Temps restant</h3>
            <p>{{ this.countdownText }}</p>
          </div>
        </div>
      </div>
    </router-link>
  </span>
</template>

<script>

export default{
  props: ['vente'],
  data(){
    return {
      end_timestamp: null,
      now_timestamp: null,
      timestampRefresh: null,
    }
  },
  methods: {

  },
  computed: {
    countdownText: function () {
      let remainingTime = this.end_timestamp - this.now_timestamp
      remainingTime = new Date(remainingTime);

      let diffDays = Math.ceil(remainingTime / (1000 * 60 * 60 * 24)) - 1;

      let day = remainingTime.getDate()
      let month = remainingTime.getMonth()

      let hours = ("0" + remainingTime.getHours()).slice(-2)
      let minutes = ("0" + remainingTime.getMinutes()).slice(-2)
      let seconds = ("0" + remainingTime.getSeconds()).slice(-2)

      return diffDays + 'J - ' + hours + 'h ' + minutes + 'm ' + seconds + 's'
    }
  },
  beforeUnmount: function(){
    console.log('INTERVAL (vente) : SUPPRIMÉ')//TODO ne pas oublier de supprimer
    clearInterval(this.timestampRefresh)
  },
  mounted(){
    let end_timestamp = Date.parse(this.vente.end_date.replace(/ /, 'T'))
    this.end_timestamp = end_timestamp

    this.timestampRefresh = setInterval(() => {
      console.log('INTERVAL (vente)')//TODO ne pas oublier de supprimer
      this.now_timestamp = new Date().getTime()
    }, 1000)
  }
}
</script>
