<template>
  <ProfileEdit />
</template>

<script>
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";
import {onMounted} from "vue";
import ProfileEdit from "../../account/ProfileEdit";
import {useStore} from "vuex";

export default {
  name: 'CustomerProfileEdit',
  components: {ProfileEdit},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "customer.dashboard"},
        {title: 'messages.profile.edit'}
      ])
    })
  }
}
</script>
