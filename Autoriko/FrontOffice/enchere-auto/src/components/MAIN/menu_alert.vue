<template>
  <span v-if="alertes">
    <h1>Vos alertes</h1>
    <div class="menu_container">
      <MenuRow v-if="alertes && alertes.length > 0"
        v-for="(elem, index) in alertes"
        v-bind:row_info="elem.alerte"
        v-bind:notif_created_at="elem.alerte.created_at"
        menu_type="alert"
        v-bind:is_last="index == alertes.length - 1">
      </MenuRow>
      <div v-else>
        <p>Vous n'avez reçu aucune alerte pour le moment.</p>
      </div>
    </div>
    <div class="menu_footer">
      <p>
        <a href="#">Afficher l'ensemble</a> - <a href="#">Marquer comme vu</a> - <a href="#">Paramètres alertes</a>
      </p>
    </div>
  </span>
</template>

<script>

import MenuRow from '@/components/MAIN/Menu/menu_row.vue'

export default{
  components:{
    MenuRow
  },
  data(){
    return {
      alertes: false,
    }
  },
  methods: {
    init(){
      this.loadData()
    },
    loadData(){
      console.log('menu alert refresh')
      api.get('/account/alertes', {params: { size: 5 } }).then(response => {
        this.alertes = response.data.alertes
        window.mitt.emit('alertesReceipt', response.data.none_read_number)
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    setAlertesRead(){
      let _alertes = []
      this.alertes.forEach(elem => {
        _alertes.push(elem.alerte.id)
      });
      api.post('/account/alertes', {'alertes' : _alertes}).then(response => {
        this.loadData()
      })
    },
    setMitter(){
      window.mitt.on('update_menu_alert', () => {
        this.loadData()
      });
      window.mitt.on('set_alert_read', () => {
        this.setAlertesRead()
      });
    }
  },
  mounted(){
    this.init()
    this.setMitter()
  }
}
</script>
