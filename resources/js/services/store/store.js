import {createStore} from "vuex";

import auth from "./auth.module"
import breadcrumbs from "./breadcrumbs.module"
import form from "./form.module"
import room from "./room.module"
import cart from "./cart.module"
import disciplines from "./disciplines.module"
import tz from "./tz.module"

const store = createStore({
  modules: {
    auth: auth,
    breadcrumbs: breadcrumbs,
    form: form,
    room: room,
    cart: cart,
    disciplines: disciplines,
    timezone: tz,
  }
})

export default store
