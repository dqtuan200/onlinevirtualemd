export const state = () => ({
    isLoggedIn: false,
    user: null
  })
  
  export const mutations = {
    SET_AUTH(state, { isLoggedIn, user }) {
      state.isLoggedIn = isLoggedIn
      state.user = user
    }
  }
  
  export const actions = {
    nuxtServerInit({ commit }, { app }) {
      if (app.$auth.loggedIn) {
        commit('SET_AUTH', { isLoggedIn: true, user: app.$auth.user })
      }
    },
    updateAuthState({ commit }, { isLoggedIn, user }) {
      commit('SET_AUTH', { isLoggedIn, user })
    }
  }