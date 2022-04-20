<template>
  <HoroscopeForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.horoscopes.edit') }}</h3>
    </template>
  </HoroscopeForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import HoroscopeForm from "./HoroscopeForm";

export default {
  name: 'HoroscopeEdit',
  components: {HoroscopeForm},
  setup(){
    const store = useStore()
    const route = useRoute()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'horoscopes', route: "admin.horoscopes"},
        {title: 'messages.horoscopes.view', route: {name: "admin.horoscopes.view", params: {id: route.params.id }}},
        {title: 'messages.horoscopes.edit'},
      ])
    })
  }
}
</script>
