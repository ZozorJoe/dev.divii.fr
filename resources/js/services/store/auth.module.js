import ApiService from "../api.service";
import {SET_ERRORS, SET_LOADING} from "./form.module";

// action types
export const VERIFY_AUTH = "verifyAuth";
export const REGISTER = "register";
export const LOGIN = "login";
export const LOGOUT = "logout";

// mutation types
export const SET_AUTH = "setAuth";
export const PURGE_AUTH = "purgeAuth";

export const store = {
  state: {
    user: null,
    authenticated: null,
  },
  getters: {
    currentUser(state) {
      return state.user
    },
    isAuthenticated(state) {
      return state.authenticated;
    },
  },
  actions: {
    [LOGIN]({ dispatch, commit }, credentials) {
      commit(SET_ERRORS);
      commit(SET_LOADING, true);
      ApiService.post("/login", credentials)
        .then((response) => {
          if(response.data.success){
            dispatch(VERIFY_AUTH)
          } else {
            commit(SET_LOADING, false);
            commit(PURGE_AUTH);
          }
        })
        .catch(({response}) => {
          commit(SET_LOADING, false);
          commit(PURGE_AUTH);
          if(response && response.data && response.data.errors){
            commit(SET_ERRORS, response.data.errors);
          }
        });
    },
    [REGISTER]({ dispatch, commit }, credentials) {
      commit(SET_ERRORS);
      commit(SET_LOADING, true);
      const request = ApiService.post("/register", credentials)
      request.then(() => {
          commit(SET_LOADING, false);
          dispatch(VERIFY_AUTH)
        })
      request.catch(({response}) => {
          commit(SET_LOADING, false);
          if(response && response.data && response.data.errors){
            commit(SET_ERRORS, response.data.errors);
          }
        });
      return request
    },
    [VERIFY_AUTH]({ commit }) {
      ApiService.setHeader();
      ApiService.get("/account")
        .then((response) => {
          if(response.data.success){
            commit(SET_AUTH, response.data.data);
          } else {
            commit(PURGE_AUTH);
          }
        })
        .catch(() => {
          commit(PURGE_AUTH);
        });
    },
    [LOGOUT]() {
      ApiService.delete("/logout")
    }
  },
  mutations: {
    [SET_AUTH](state, user) {
      state.authenticated = true;
      state.user = user
    },
    [PURGE_AUTH](state) {
      state.authenticated = false;
      state.user = null
    }
  }
}

export default store
