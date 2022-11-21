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
      <h1>Conversations</h1>
      <div class="panel" v-if="!loadingContent">
        <h3>Voici vos dernières conversations (total: {{ conversations_count }})</h3>
        <div class="conversations" v-for="elem in conversations">
          <router-link :to="{ name: 'Conversation', params: { uuid: elem.conversation.uuid } }">
            <div style="border: 1px solid black; padding: 10px;">
              <div class="title">
                Titre : {{ elem.conversation.title }}
              </div>
            </div>
          </router-link>
        </div>
      </div>
      <p v-html="loadingText"></p>
    </div>
  </div>
</template>

<script>

export default{
  name: 'Conversations',
  data() {
    return {
      conversations: null,
      conversations_count: null,
      loadingContent: true,
      loadingText: '',
      loadingTimeout: null
    }
  },
  methods: {
    init(){
      api.get('/account/conversations').then(response => {
        this.conversations = response.data.conversations
        this.conversations_count = response.data.count
      }).catch(error => {
        alert((error.response.data.message_status) ? error.response.data.message_status : "Votre action n'a pû aboutir, une erreur inconnue s'est produite.")
      })
    }
  },
  watch: {
    conversations: function(){
      if(this.conversations){
        this.loadingContent = false
        this.loadingText = null
        clearInterval(this.loadingTimeout);
      }
    }
  },
  created(){
    let self = this
    this.loadingTimeout = setInterval(function(){
      if(self.loadingContent == true){
        if(self.loadingText.length == 0 || self.loadingText == '<br>')
          self.loadingText = '.'
        else if(self.loadingText.length == 1)
          self.loadingText = '..'
        else if(self.loadingText.length == 2)
          self.loadingText = '...'
        else if(self.loadingText.length == 3)
          self.loadingText = '<br>'
      }
    }, 200);
  },
  mounted(){
    this.init()
  }
}
</script>
