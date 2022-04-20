import moment from 'moment-timezone'
import {SET_TIMEZONE} from "./store/tz.module";

const tzService = {
  setActiveTimezone(store, timezone) {
    store.commit(SET_TIMEZONE, timezone)
    localStorage.setItem("timezone", timezone);
    moment.tz.setDefault(timezone);
  },

  getActiveTimezone(value) {
    if(localStorage.getItem("timezone")){
      return localStorage.getItem("timezone");
    }

    if(value){
      return value
    }

    return moment.tz.guess();

  }
};

export default tzService;
