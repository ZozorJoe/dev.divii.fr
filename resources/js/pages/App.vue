<template>
  <router-view />
</template>

<script>
import {computed, onMounted, watch} from "vue";
import {useStore} from "vuex";
import {useRouter, useRoute} from "vue-router";
import {VERIFY_AUTH} from "../services/store/auth.module";
import {SET_TIMEZONE} from "../services/store/tz.module";
import tzService from "../services/tz.service";
import moment from "moment-timezone";

export default {
  name: 'App',
  setup() {
    const store = useStore()
    const router = useRouter()
    const route = useRoute()
    const isAuthenticated = computed(() => store.getters.isAuthenticated)

    const redirect = (route) => {
      if(route.meta.requiresAuth && (isAuthenticated.value===false)){
        location.href = router.resolve({ name: 'login', query: { redirect: route.fullPath }}).fullPath
        return true;
      }else if(route.meta.requiresGuest && isAuthenticated.value) {
        if(route.query.redirect && route.query.redirect !== "/auth/logout"){
          location.href = route.query.redirect
        }else{
          location.href = router.resolve({name: 'admin.dashboard'}).fullPath
        }
        return true;
      }
      return false;
    }

    onMounted(() => {
      verifyAuth()
      const timezone = tzService.getActiveTimezone(moment.tz.guess())
      store.commit(SET_TIMEZONE, timezone)
    })

    const verifyAuth = () => {
      store.dispatch(VERIFY_AUTH)
      setTimeout(verifyAuth, 60000);
    }

    watch(() => isAuthenticated.value, () => { redirect(route) })

    router.beforeEach((to, from, next) => {
      if(redirect(to)){
        next(false)
      }else {
        next()
      }
    })

  },
}
</script>
