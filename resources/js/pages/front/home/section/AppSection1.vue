<template>
  <!--begin::Section 1-->
  <div class="pb-20 section-1" v-if="disciplines.length">
    <!--begin::Wrapper-->
    <div class=" border-top border-bottom border-bottom-1 border-top-1">
      <!--begin::Container-->
      <div class="container-fluid">

        <!--begin::Wrapper-->
        <!--<div class="d-flex">
          &lt;!&ndash;begin::Item&ndash;&gt;
            <div
              v-for="discipline in disciplines"
              :key="`discipline-item-${discipline.id}`"
              :id="`discipline-item-${discipline.id}`"
              class="text-center flex-1 px-5 py-9">

              <div class="d-flex align-items-center">
                &lt;!&ndash;begin::Icon&ndash;&gt;
                <div class="symbol symbol-50px me-3">
                  <img alt="icon" :src="`/d/picto-${discipline.id}.jpg`" />
                </div>
                &lt;!&ndash;end::Icon&ndash;&gt;

                &lt;!&ndash;begin::name&ndash;&gt;
                <div class="d-flex justify-content-start flex-column">
                  <router-link
                    :to="{name: 'front.disciplines.view', params: {id: discipline.id}}"
                    class="thematic-item canela-thin">
                    {{ discipline.name }}
                  </router-link>
                </div>
                &lt;!&ndash;end::name&ndash;&gt;
              </div>

            </div>
          &lt;!&ndash;end::Item&ndash;&gt;
        </div>-->
        <!--end::Wrapper-->

        <!--begin::Slider-->
        <div class="tns tns-default">
          <!--begin::Wrapper-->
          <div
            class="disciplines-slider">
            <!--begin::Item-->
            <carousel :settings="settings">
            <slide
              v-for="discipline in disciplines"
              :key="`discipline-item-${discipline.id}`"
              :id="`discipline-item-${discipline.id}`"
              class="text-center px-5 py-9">

              <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-50px me-3">
                  <img alt="icon" :src="`/d/picto-${discipline.id}.jpg`" />
                </div>
                <!--end::Icon-->

                <!--begin::name-->
                <div class="d-flex justify-content-start flex-column">
                  <router-link
                    :to="{name: 'front.disciplines.view', params: {id: discipline.id}}"
                    class="text-hover-primary thematic-item canela-thin">
                    {{ discipline.name }}
                  </router-link>
                </div>
                <!--end::name-->
              </div>

            </slide>
              <template #addons="{ slidesCount }">
                <Navigation v-if="slidesCount > 1" />
              </template>
            </carousel>
            <!--end::Item-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Slider-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 1-->
</template>

<script>
import {computed, nextTick, onMounted, ref, watch} from "vue";
import {useStore} from "vuex";
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';

export default {
  name: "AppSection1",
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation
  },
  data: () => ({
      // carousel settings
      settings: {
          itemsToShow: parseInt(screen.width/250),
          itemsToScroll: parseInt(screen.width/250),
          snapAlign: 'left',
          slideWidth: 'left',
          autoplay: false,
          transition: 3000,
          wrapAround: true
      }
  }),
  setup() {
    const store = useStore()

    const disciplines = computed(() => store.getters.disciplines)

    return {
      disciplines
    }
  }
};
</script>
