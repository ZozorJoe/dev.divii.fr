<template>
  <div></div>
</template>

<script>
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import {onMounted} from "vue";
import {LOGOUT, PURGE_AUTH} from "../../../services/store/auth.module";

export default {
  name: "KTLogout",
  setup() {
    const store = useStore()
    const router = useRouter()

    onMounted(() => {
      store.dispatch(LOGOUT)
        .then(() => {
          store.commit(PURGE_AUTH)
          router.push({name: 'login'})
        })
        .catch(() => {
          store.commit(PURGE_AUTH)
          router.push({name: 'login'})
        });
    })
  },
};
</script>
