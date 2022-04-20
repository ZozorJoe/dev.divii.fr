<template>
  <!--begin::Section 7-->
  <div class="py-20 section-7" v-if="experts.length">
    <!--begin::Wrapper-->
    <div>
      <!--begin::Container-->
      <div class="container">

        <!--begin::Row-->
        <div class="row w-100 gy-10 align-items-center">

          <!--begin::Col-->
          <div class="col-md-6 z-index-0 px-20">
            <div
             id="kt_experts_carousel"
             class="carousel carousel-custom slide"
             data-bs-ride="carousel"
             data-bs-interval="5000">

              <!--begin::Carousel-->
              <div class="carousel-inner overflow-visible">
                <!--begin::Item-->
                <div
                  v-for="(expert, index) in experts"
                  :key="`expert-item-${expert.id}`"
                  class="carousel-item position-relative"
                  :class="{active: index === 0}">
                  <img class="w-450px h-450px object-fit-cover rounded-custom" :src="`/u/image-${expert.id}.jpg`" alt="" />
                  <!--<img alt="icon" :src="`/img/icon/icon-${randomIcon()}.svg`" class="position-absolute w-100px" style="top: -25px; left: 25px;">
                --></div>
                <!--end::Item-->
              </div>
              <!--end::Carousel-->

              <!--begin::Heading-->
              <div class="text-center">
                <!--begin::Carousel Indicators-->
                <ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
                  <li
                    v-for="(expert, index) in experts"
                    data-bs-target="#kt_experts_carousel"
                    :data-bs-slide-to="index"
                    :class="{active: index === 0}"
                    class="ms-1"></li>
                </ol>
                <!--end::Carousel Indicators-->
              </div>
              <!--end::Heading-->
            </div>
          </div>
          <!--end::Col-->

          <!--begin::Col-->
          <div class="col-md-6 z-index-1">
            <!--begin::Heading-->
            <div class="section-heading text-left">
              <div class="concept-top">
              <!--begin::Title-->
                <h3 class="h3 h3-concept mb-10 canela-thin"><span class="canela-thin-italic">Nos</span> consultants</h3>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="concept-description mb-20 canela-thin-italic">
                  Découvrez notre équipe d'experts
                  engagés à vous accompagner dans
                  votre chemin vers une meilleure
                  connaissance de vous-même.
                </div>
              </div>
              <!--end::Description-->

              <!--begin::Select-->
              <router-link :to="{name: 'front.experts.list'}" class="fiche-btn btn rounded-pill bg-red-4 btn-icon-dark mb-20 text-uppercase">Découvrir
                <span class="svg-icon svg-icon-1 mx-2">
                 <img src="/img/icon/arrow-dark.svg" alt="right">
                </span></router-link>
              <!--end::Select-->

            </div>
            <!--end::Heading-->

          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 7-->
</template>

<script>
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";
import {onMounted, ref} from "vue";
import ApiService from "../../../../services/api.service";

export default {
  name: "AppSection7",
  setup() {
    const store = useStore()
    const { t } = useI18n()

    const randomIcon = () => {
      const values = [1, 2, 3, 4, 5, 6, 7, 8]
      const index = Math.floor(Math.random()*values.length);
      return values[index];
    }

    const experts = ref([])
    const loadExperts = () => {
      const params = {params:{'per-page': 3}}
      ApiService.list('/experts', params, t('expert'), setExperts, store, t)
    }
    const setExperts = (value) => {
      experts.value = value
    }
    onMounted(loadExperts)

    return {
      experts,
      randomIcon,
    }
  }
};
</script>
