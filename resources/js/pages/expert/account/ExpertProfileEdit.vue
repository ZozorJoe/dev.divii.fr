<template>
  <ProfileEdit />
</template>

<script>
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";
import {onMounted} from "vue";
import ProfileEdit from "../../account/ProfileEdit";
import {useStore} from "vuex";

export default {
  name: 'ExpertProfileEdit',
  components: {ProfileEdit},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'messages.profile.edit'}
      ])
    })
  }
}
</script>
