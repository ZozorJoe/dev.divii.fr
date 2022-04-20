<template>
  <FormationFrom>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.formations.edit') }}</h3>
    </template>
  </FormationFrom>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import FormationFrom from "./FormationForm";

export default {
  name: 'FormationEdit',
  components: {FormationFrom},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'formations', route: "expert.formations"},
        {title: 'messages.formations.edit'},
      ])
    })

  }
}
</script>
