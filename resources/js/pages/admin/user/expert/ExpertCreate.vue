<template>
  <ExpertForm>
    <template v-slot:title>
    <h3 class="fw-bolder m-0">{{ $t('messages.experts.create') }}</h3>
    </template>
  </ExpertForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import ExpertForm from "./ExpertForm";

export default {
  name: 'ExpertCreate',
  components: {ExpertForm},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'experts', route: "admin.experts"},
        {title: 'messages.experts.create'},
      ])
    })
  }
}
</script>
