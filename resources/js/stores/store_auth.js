const state = () => ({
server:'http://laravel.test',
cookies:''
})

const mutations = {}

const actions = {}

const getters ={
 loggedIn: state  => state.cookies,
 apiUrl(state){
  return state.server + '/api'
 },
 storageUrl(state){
  return state.server + '/storage'
 },
 serverUrl(state){
  return state.server
 },
}

export default {
 namespaced:true,
 state,mutations,actions,getters
}