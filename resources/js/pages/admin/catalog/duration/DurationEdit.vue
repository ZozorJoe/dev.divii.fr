<template>
  <DurationForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.durations.edit') }}</h3>
    </template>
  </DurationForm>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import DurationForm from "./DurationForm";

export default {
  name: 'DurationEdit',
  components: {DurationForm},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'durations', route: "admin.durations"},
        {title: 'messages.durations.edit'},
      ])
    })

  }
}
</script>
