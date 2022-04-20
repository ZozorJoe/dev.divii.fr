// mutation types
import tzService from "../tz.service";
import moment from "moment-timezone";

export const SET_TIMEZONE = "setTimezone";

export const store = {
  state: {
    timezone: null,
  },
  getters: {
    timezone(state) {
      return state.timezone
    },
  },
  mutations: {
    [SET_TIMEZONE](state, tz) {
      console.log('SET_TIMEZONE', tz)
      state.timezone = tz
    },
  }
}

export default store
