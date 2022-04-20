<template>
  <!--begin::Section 0-->
  <div class="py-20 section-0">
    <img src="/img/home-circle.svg" class="hp-bg-circle"/>
    <!--begin::Wrapper-->
    <div>
      <!--begin::Container-->
      <div class="container-fluid container-home">

        <div class="row">
          <!--begin::Heading-->
          <div class="col-lg-5 col-xl-5 section-0-col-1 z-index-1">
            <div class="description-bloc">
              <!--begin::Title-->
              <div class=" main-text-1">
                <span class="">Un espace unique dédié à l'évolution personnelle de chacun, né de la conviction que l'ésotérisme ne doit plus être ésotérique.</span>
              </div>
              <div class="main-description">
                <p class="main-text-2">
                  feel the light
                </p>
                <p class="main-text-3">
                  see the light
                </p>
                <p class="main-text-4">
                  be the light
                </p>
              </div>
            </div>
          </div>
          <!--end::Heading-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 0-->
</template>

<script>
import {useStore} from "vuex";
import {computed} from "vue";

export default {
  name: "AppHeader",
  setup(){
    const store = useStore()
    const isAuthenticated = computed(() => store.getters.isAuthenticated)
    const cart = computed(() => store.getters.currentCart)
    return {
      isAuthenticated,
      cart,
    }
  }
};
</script>
