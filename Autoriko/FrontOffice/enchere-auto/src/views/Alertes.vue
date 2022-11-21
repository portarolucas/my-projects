<template>
  <div class="main-content">
    <section class="section_1 align-center">
      <h1 class="title-page">Vos alertes</h1>
      <a v-for="elem in alertes" :href="elem.alerte.link">
        <div class="block-alerte" v-bind:class="{ 'marked' : elem.alerte.alert_read == '0' }">
          <div class="content-text">
            <p v-html="elem.alerte.message"></p>
            <p class="notif_time">il y a {{ elem.alerte.created_at }}</p>
          </div>
        </div>
      </a>
    </section>
    <hr>
    <section class="section_2 align-center" v-if="lastPage != null && lastPage != 1">
      <div class="navigation-page">
        <button @click="beforePage">&lt;</button>
        <button @click="afterPage">></button>
      </div>
      <p class="number-of-page"><span @click="actualPage = 1" class="text-link">1</span><span class="separate-bar-p">...</span>{{ actualPage }}<span class="separate-bar-p">...</span><span @click="actualPage = lastPage" class="text-link">{{ lastPage }}</span></p>
    </section>
  </div>
</template>

<script>

import moment from 'moment'

export default {
  name: 'Alertes',
  data(){
    return {
      alertes: [],
      actualPage: 1,
      lastPage: null
    }
  },
  methods:{
    init(){
      this.loadData()
    },
    loadData(){
      api.get('/account/alertes', {params: { size: 8, page: this.actualPage } }).then(response => {
        this.alertes = response.data.alertes
        this.lastPage = response.data.last_page_number
        this.alertes.forEach((elem, i) => {
          elem.alerte.created_at = this.getDifferenceDate(elem.alerte.created_at)
        });

        console.log(this.alertes)
        //let alertsNoneRead = this.alertes.filter(elem => elem.alerte.alert_read == 0);
        //window.mitt.emit('alertesReceipt', { alertes: alertsNoneRead })
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    afterPage(){
      if(this.lastPage != null && (this.actualPage + 1) <= this.lastPage){
        this.actualPage++
      }
    },
    beforePage(){
      if((this.actualPage - 1) > 0){
        this.actualPage--
      }
    },
    getDifferenceDate(created_date){
      let receiptDate = moment(created_date, "YYYY/MM/DD HH:mm:ss")
      let actualTime = moment()
      let diffMoment = moment.duration(actualTime.diff(receiptDate))

      let _diffMoment = diffMoment

      let _diffYears = _diffMoment.years()
      let _diffMonths = _diffMoment.months()
      let _diffWeeks = _diffMoment.weeks()
      let _diffDays = _diffMoment.days()
      let _diffHours = _diffMoment.hours()
      let _diffMinutes = _diffMoment.minutes()
      let _diffSeconds = _diffMoment.seconds()

      if(_diffYears > 0){
        return _diffYears + ' année(s)'
      }
      else if(_diffMonths > 0){
        return _diffMonths + ' mois'
      }
      else if(_diffWeeks > 0){
        return _diffWeeks + ' semaines'
      }
      else if(_diffDays > 0){
        return _diffDays + ' jour(s)'
      }
      else if(_diffHours > 0){
        return _diffHours + ' heure(s)'
      }
      else if(_diffMinutes > 0){
        return _diffMinutes + ' minute(s)'
      }
      else if(_diffSeconds > 0){
        return _diffSeconds + ' seconde(s)'
      }
      else{
        return ''
      }
    },
    setAlertesRead(){
      let _alertes = []
      this.alertes.forEach(elem => {
        _alertes.push(elem.alerte.id)
      });
      api.post('/account/alertes', {'alertes' : _alertes})
      window.mitt.emit('update_menu_alert')
    },
    changeQuery (){
      let query = new Object()
      if(this.actualPage != false && this.actualPage != 1)
        query.page = this.actualPage

      this.$router.push({query: { ...query }})
   }
  },
  watch: {
    '$route': function(){
      this.setAlertesRead()
      if(this.$route.name == 'Alertes'){
        this.alertes = []
        this.init()
      }
    },
    actualPage: function(){
      this.changeQuery()
    }
  },
  created(){
    if(this.$route.query.page){
      this.actualPage = this.$route.query.page
    }
  },
  mounted(){
    this.init()
  }
}
</script>

<style scoped src="@/assets/css/pages/alertes/main.css"></style>

<style scoped lang="scss">
  .text-link{
    cursor: pointer;
    text-decoration: underline;
  }
  .block-alerte.marked{
    background-color: rgb(185 185 185 / 23%);
  }
</style>
