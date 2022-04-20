<template>
  <Chat>
    <template v-slot:tool-bar>
      <KtToolbar>
      </KtToolbar>
    </template>
  </Chat>
</template>

<script>
import Chat from "../../chat/Chat";
import {useStore} from "vuex";
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";

export default {
  name: 'ExpertChat',
  components: {Chat},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'home', route: "home"},
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'chat'},
      ])
    })

  }
}
</script>
