import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    // ...
    state : {
        user:false,
    },

    getters: {
        getUpdateProfile(state){
            return state.user
        }
    },

    mutations: {
        updateUser(state,data){
            state.user = data
        },
    },
    /* 
    actions :{
        changeCounterAction({commit},data){
            //console.log(commit)
            commit('changeTheCounter',data)
        }
    } */



})