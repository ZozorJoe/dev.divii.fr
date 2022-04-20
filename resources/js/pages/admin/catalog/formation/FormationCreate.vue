<template>
  <FormationFrom>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.formations.create') }}</h3>
    </template>
  </FormationFrom>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import FormationFrom from "./FormationForm";

export default {
  name: 'FormationCreate',
  components: {FormationFrom},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'formations', route: "admin.formations"},
        {title: 'messages.formations.create'},
      ])
    })

  }
}
</script>
