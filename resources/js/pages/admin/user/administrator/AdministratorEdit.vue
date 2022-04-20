<template>
  <AdministratorForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.administrators.edit') }}</h3>
    </template>
  </AdministratorForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import AdministratorForm from "./AdministratorForm";

export default {
  name: 'AdministratorEdit',
  components: {AdministratorForm},
  setup(){
    const store = useStore()
    const route = useRoute()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'administrators', route: "admin.administrators"},
        {title: 'messages.administrators.view', route: {name: "admin.administrators.view", params: {id: route.params.id }}},
        {title: 'messages.administrators.edit'},
      ])
    })
  }
}
</script>
