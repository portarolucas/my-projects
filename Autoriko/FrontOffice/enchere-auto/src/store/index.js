import { createStore } from 'vuex'
import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
})

export default createStore({
  state: {
    user: false,
    userToken: false,
    remember_email: false,
    remember_password: false,
    askForgotPassword: false,
    site_info: false,
    site_brands: false
  },
  mutations: {
    setUser(state, user){
      state.user = user
    },
    setUserToken(state, userToken){
      state.userToken = userToken
    },
    setRememberCredentials(state, userCredentials){
      state.remember_email = userCredentials['email']
      state.remember_password = userCredentials['password']
    },
    setAskForgotPassword(state, ask){
      state.askForgotPassword = ask
    },
    setSiteInfo(state, site_info){
      state.site_info = site_info
    },
    setSiteBrands(state, site_brands){
      state.site_brands = site_brands
    },
    notRememberUser(state){
      state.remember_email = false
      state.remember_password = false
    },
    disconnectUser(state){
      state.user = false
      state.userToken = false //X-XSRF-TOKEN - Header
    }
  },
  actions: {
  },
  modules: {
  },
  plugins: [vuexLocal.plugin]
})
