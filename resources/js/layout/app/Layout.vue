<template>
  <div class="front bg-front">
    <AppHeader />
    <CommentCaMarche/>
    <router-view />
    <AppFooter />
    <KTCartDrawer />
  </div>
</template>

<script>
import { onMounted} from "vue";
import KTCartDrawer from "../../pages/front/checkout/CartDrawer";
import AppFooter from "../../pages/front/base/AppFooter";
import AppHeader from "../../pages/front/base/AppHeader";
import CommentCaMarche from "../../pages/front/base/CommentCaMarche";
import ApiService from "../../services/api.service";
import {useStore} from "vuex";
import {SET_DISCIPLINES} from "../../services/store/disciplines.module";
import {useI18n} from "vue-i18n";

export default {
  name: "AppLayout",
  components: {KTCartDrawer, AppFooter, AppHeader, CommentCaMarche},
  setup(){
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      $('body').attr('class', 'bg-white position-relative')
    })

    const loadDisciplines = () => {
      ApiService.list('/disciplines', null, t('discipline'), setDisciplines, store, t)
    }
    const setDisciplines = (value) => {
      store.commit(SET_DISCIPLINES, value)
    }
    onMounted(loadDisciplines)

  }
};
</script>
