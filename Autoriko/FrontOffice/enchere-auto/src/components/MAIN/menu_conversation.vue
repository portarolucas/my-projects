<template>
  <span v-if="conversations">
    <h1>Vos conversations</h1>
    <div class="menu_container">
      <MenuRow v-if="conversations && conversations.length > 0"
        v-for="(elem, index) in conversations"
        v-bind:row_info="elem.conversation"
        v-bind:notif_created_at="elem.conversation.created_at"
        menu_type="conversation"
        v-bind:is_last="index == conversations.length - 1">
      </MenuRow>
      <div v-else>
        <p>Vous n'avez aucune conversation pour le moment.</p>
      </div>
    </div>
    <div class="menu_footer">
      <p>
        <a href="#">Afficher l'ensemble</a> - <span style="cursor: pointer;" @click="setConversationsRead">Marquer comme vu</span> - <a href="#">Paramètres conversations</a>
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
      conversations: false
    }
  },
  methods: {
    init(){
      this.loadData()
    },
    loadData(){
      console.log('menu conversation refresh')
      api.get('/account/conversations', {params: { size: 3 } }).then(response => {
        this.conversations = response.data.conversations
        window.mitt.emit('conversationsReceipt', response.data.none_read_number)
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      }).catch(() => {
        alert("Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    },
    setMitter(){
      window.mitt.on('update_menu_conversation', () => {
        this.loadData()
      });
    },
    setConversationsRead(){
      let _conversations = []
      this.conversations.forEach(elem => {
        _conversations.push(elem.conversation.uuid)
      });

      api.post('/account/conversations', {'conversations' : _conversations}).then(response => {
        this.loadData()
      })
    }
  },
  mounted(){
    this.init()
    this.setMitter()
  }
}
</script>
