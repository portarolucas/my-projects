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
    <div>
      <h1><u>{{ this.title }}</u></h1>
      <h3>Voici les derniers messages (total: {{ messages_count }})</h3>
      <div class="panel">
        <div class="messages">
            <div class="message" v-bind:class="{ 'self-message' : elem.message.user_isAdmin == false }" v-for="elem in messages">
              {{ elem.message.message }}
            </div>
        </div>
        <div class="footer-conversation">
          <form @submit.prevent="createMessage" class="send-message" style="width: 100%;">
            <input v-model="newMessage" type="text" placeholder="Envoyer un message"/>
            <button>Envoyer</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery'

export default {
  name: 'Conversation',
  data(){
    return {
      messages: [],
      title: '',
      uuid: null,
      messages_count: '',
      newMessage: '',
      messagesRefresh: null
    }
  },
  watch:{
    messages: function(){
      this.updated()
    }
  },
  methods:{
    init(){
      this.loadData();
      this.setConversationRead()
    },
    refreshMessage(){
      this.loadData();
    },
    updated(){
      window.scrollTo(0,document.body.scrollHeight);
    },
    loadData(){
      //this.$route.params.uuid
      api.get('/conversations/' + this.uuid + '/messages?size=20').then(response => {
        this.messages = response.data.messages.reverse();//reverse pour avoir les derniers messages posté en bas
        this.messages_count = response.data.count
      }).catch(error => {
        if(error.response.status === 403){
          console.log('interdit')
          this.$router.push('/conversations')
        }else{
          alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        }
      })
      api.get('/conversations/' + this.uuid).then(response => {
        this.title = response.data.conversation.title
        this.admin = response.data.conversation.admin_info
      }).catch(error => {
        if(error.response.status === 403){
          console.log('interdit')
          this.$router.push('/conversations')
        }else{
          alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
        }
      })
    },
    createMessage(){
      if(this.newMessage != ''){
        api.post('/conversations/' + this.uuid + '/messages', {'message' : this.newMessage}).then(response => {
          alert(response.data.message_status)
          this.loadData();
          this.newMessage = '';
        })
      }else{
        alert("Vous devez entrer un message et ensuite l'envoyer...")
      }
    },
    setConversationRead(){
      let _conversations = []
      _conversations.push(this.uuid)

      api.post('/account/conversations', {'conversations' : _conversations}).then(response => {
        window.mitt.emit('update_menu_conversation')
      })
    }
  },
  updated(){
    window.scrollTo(0,document.body.scrollHeight);
  },
  created(){
    this.uuid = this.$route.params.uuid;
    this.messagesRefresh = setInterval(() => {
      console.log('INTERVAL (conversation)')//TODO ne pas oublier de supprimer
      this.refreshMessage();
    }, 1000)
  },
  mounted(){
    this.init();
  },
  beforeUnmount: function () {
    console.log('INTERVAL (conversation) : SUPPRIMÉ')//TODO ne pas oublier de supprimer
    clearInterval(this.messagesRefresh);
  }
}
</script>

<style lang="scss" scoped>
body{
  padding: 0;
}

.messages{
  display: flex;
  flex-wrap: wrap;
  -webkit-flex-direction: column;
  flex-direction: column;
  background-color: #ecf0f1;
  padding: 1rem 1rem 0 1rem;
  margin-bottom: 60px;

  .message{
    width: 70%;
    align-self: flex-start;
    margin-bottom: 1rem;
    padding: 5px;
    border: 1px solid black;

    &.self-message{
      align-self: flex-end !important;
    }
  }
}

.footer-conversation form{
  position: fixed;
  bottom: 0px;
  width: 100%;
  height: 50px;
  background-color: #7f8c8d;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  flex-wrap: nowrap;
  border-top: 1px solid grey;

  input[type="text"]{
    border: none;
    width: 80%;
    height: 50px;
    padding: 0 1rem;
    outline-color: none;
    outline: 0;
    &:hover{
      outline: 0;
    }
  }
  button{
    border: 0;
    width: 20%;
    height: 50px;
    color: white;
    z-index: 999;
    background-color: #7f8c8d;
    cursor: pointer;
  }
}
</style>
