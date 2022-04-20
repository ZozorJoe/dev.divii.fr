// mutation types
import {SET_ERRORS, SET_LOADING} from "./form.module";
import ApiService from "../api.service";

export const SET_CART = "setCart";
export const GET_CART = "getCart";

export const store = {
  state: {
    cart: null,
  },
  getters: {
    currentCart(state) {
      return state.cart
    },
  },
  mutations: {
    [SET_CART](state, cart) {
      state.cart = cart
    },
  },
  actions: {
    [GET_CART]({commit }) {
      commit(SET_ERRORS);
      commit(SET_LOADING, true);
      ApiService.get("/carts")
        .then((response) => {
          commit(SET_LOADING, false);
          if(response.data.success){
            commit(SET_CART, response.data.data)
          } else {
            commit(SET_CART, null)
          }
        })
        .catch(({response}) => {
          commit(SET_LOADING, false);
          commit(SET_CART, null)
          if(response && response.data && response.data.errors){
            commit(SET_ERRORS, response.data.errors);
          }
        });
    },
  }
}

export default store
