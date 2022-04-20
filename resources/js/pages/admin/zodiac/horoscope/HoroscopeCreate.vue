<template>
  <HoroscopeForm>
    <template v-slot:title>
    <h3 class="fw-bolder m-0">{{ $t('messages.horoscopes.create') }}</h3>
    </template>
  </HoroscopeForm>
</template>

<script>
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import HoroscopeForm from "./HoroscopeForm";

export default {
  name: 'HoroscopeCreate',
  components: {HoroscopeForm},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'horoscopes', route: "admin.horoscopes"},
        {title: 'messages.horoscopes.create'},
      ])
    })
  }
}
</script>
