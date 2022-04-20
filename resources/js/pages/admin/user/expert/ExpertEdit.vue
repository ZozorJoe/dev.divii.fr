<template>
  <ExpertForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.experts.edit')}}</h3>
    </template>
  </ExpertForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import ExpertForm from "./ExpertForm";

export default {
  name: 'ExpertEdit',
  components: {ExpertForm},
  setup(){
    const store = useStore()
    const route = useRoute()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'experts', route: "admin.experts"},
        {title: 'messages.experts.view', route: {name: "admin.experts.view", params: {id: route.params.id }}},
        {title: 'messages.experts.edit'},
      ])
    })
  }
}
</script>
