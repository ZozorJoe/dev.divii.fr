<template>
  <!--begin::Section 6-->
  <div class="py-20 section-6" v-if="formations.length">
    <!--begin::Wrapper-->
    <div>
      <!--begin::Container-->
      <div class="container-fluid">

        <!--begin::Heading-->
        <div class="section-heading text-center mb-10">
          <!--begin::Title-->
          <h3 class=" section6-title canela-thin fw-normal">Nos <span class="canela-thin-italic">prochains</span> cours</h3>
          <!--end::Title-->
        </div>
        <!--end::Heading-->

        <!--begin::Slider-->
        <div class="tns tns-default">
          <!--begin::Wrapper-->
          <div class="formations-slider" id="formations-slider">
            <!--begin::Item-->
            <carousel :settings="settings">
            <slide
              v-for="formation in formations"
              :key="`formation-item-${formation.id}`"
              :id="`formation-item-${formation.id}`"
              class="h-400px calendar-item-wrapper">
              <FormationItem
                class="me-5 formation-item-slide calendar-item"
                :formation="formation" />
            </slide>
              <template #addons>
                <Navigation />
              </template>
            </carousel>
            <!--end::Item-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Slider-->

        <!--begin::Buttons-->
        <div class="section-heading text-center my-10">
          <!--begin::Calendrier-->
          <router-link
            :to="{name:'front.calendar'}"
            class="fiche-btn btn-calendrier btn rounded-pill bg-yellow px-20 text-uppercase">
            Calendrier
          </router-link>
          <!--end::Calendrier-->
        </div>
        <!--end::Buttons-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 6-->
</template>

<script>
import {nextTick, onMounted, ref} from "vue";
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";
import ApiService from "../../../../services/api.service";
import FormationItem from "./FormationItem";
/*import FormationItem from "../../Formation/FormationItem";*/
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';

export default {
  name: "AppSection6",
  components: {FormationItem,
      Carousel,
      Slide,
      Pagination,
      Navigation
  },
    data: () => ({
    // carousel settings
    settings: {
        itemsToShow: parseInt(screen.width/250),
        snapAlign: 'left',
        autoplay: false,
        transition: 2000,
        wrapAround: true
    }
}),
  setup() {
    const store = useStore()
    const { t } = useI18n()



    const formations = ref([])
    const loadFormations = () => {
      ApiService.list('/formations', {params:{with:'user'}}, t('formation'), setFormations, store, t)
    }
    const setFormations = (value) => {
      formations.value = value
      if(value.length){
        //nextTick(initTinySliders)
      }
    }
    onMounted(loadFormations)

    return {
      formations
    }
  }
};
</script>
