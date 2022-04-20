<template>
  <DisciplineForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.disciplines.edit') }}</h3>
    </template>
  </DisciplineForm>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import DisciplineForm from "./DisciplineForm";

export default {
  name: 'DisciplineEdit',
  components: {DisciplineForm},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'disciplines', route: "admin.disciplines"},
        {title: 'messages.disciplines.edit'},
      ])
    })

  }
}
</script>
