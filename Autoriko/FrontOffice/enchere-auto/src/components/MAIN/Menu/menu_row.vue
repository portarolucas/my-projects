<template>
  <a :href="row_info.link" v-if="menu_type == 'alert'">
    <div class="menu_row" v-bind:class="{ 'marked' : row_info.alert_read == '0' }">
      <p v-html="row_info.message"></p>
      <p class="notif_time">il y a {{ countdownText }}</p>
    </div>
  </a>
  <router-link :to="{ name: 'Conversation', params: { uuid: row_info.uuid } }" v-else-if="menu_type == 'conversation'">
    <div class="menu_row" v-bind:class="{ 'marked' : row_info.conversation_read == '0' }">
      <p><b>{{ row_info.title }}</b></p>
      <p class="notif_time">il y a {{ countdownText }}</p>
    </div>
  </router-link>
  <hr v-if="!is_last">
</template>

<script>

import moment from 'moment'

export default{
  props: ['row_info', 'notif_created_at', 'menu_type', 'is_last'],
  data(){
    return {
      receiptDate: null,
      timestampRefresh: null,
      diffMoment: null,
      createSince_text: ''
    }
  },
  computed: {
    countdownText: function () {
      let _diffMoment = this.diffMoment

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
    }
  },
  beforeUnmount: function(){
    clearInterval(this.timestampRefresh)
  },
  beforeMount(){
    this.receiptDate = moment(this.notif_created_at, "YYYY/MM/DD HH:mm:ss")
    let actualTime = moment()
    this.diffMoment = moment.duration(actualTime.diff(this.receiptDate))

    this.timestampRefresh = setInterval(() => {
      this.diffMoment.add(1, 'seconds')
    }, 1000)
  }
}
</script>

<style lang="scss" scoped>
  .menu_row.marked{
    background-color: rgb(185 185 185 / 23%);
  }
</style>
