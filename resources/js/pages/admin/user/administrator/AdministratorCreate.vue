<template>
  <AdministratorForm>
    <template v-slot:title>
    <h3 class="fw-bolder m-0">{{ $t('messages.administrators.create') }}</h3>
    </template>
  </AdministratorForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import AdministratorForm from "./AdministratorForm";

export default {
  name: 'AdministratorCreate',
  components: {AdministratorForm},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'administrators', route: "admin.administrators"},
        {title: 'messages.administrators.create'},
      ])
    })
  }
}
</script>
