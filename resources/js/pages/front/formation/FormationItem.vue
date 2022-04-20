<template>
  <!--begin:: Card-->
  <div class="card border-hover-primary h-100">
    <!--begin:: Card body-->
    <div class="card-body overlay p-5">

      <!--begin::Image-->
      <div
        class="formation-bg overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover min-h-200px position-relative"
         :style="`background-image:url('/f/image-${formation.id}.jpg')`">
        <div
          v-if="formation.start_at"
          class="position-absolute top-100 translate-middle w-70px h-70px radius-50 font-moche-regular fw-normal text-center"
          :class="`bg-icon-${icon}`"
          style="right: -25px;">
          <div class="w-100 fs-1 mt-2">{{ $filters.formatDay(formation.start_at)}}</div>
          <div class="w-100 fs-6 mt-n2 text-uppercase">{{ $filters.formatMonth(formation.start_at)}}</div>
        </div>
      </div>
      <!--end::Image-->

      <!--begin::Link-->
      <router-link
        :to="{name: 'front.formations.view', params: {id: formation.id}}"
        class="overlay-layer front"
        :class="`bg-icon-${icon}`">
          <span class="fs-3 text-dark">Découvrir</span>
      </router-link>
      <!--end::Link-->

      <!--begin::Name-->
      <div class="formation-description d-flex justify-content-start flex-column mt-2">
        <div class="formation-name text-dark text-hover-primary font-noe-display-regular">
          {{ formation.name }}
      </div>
      <!--end::Name-->

      <!--begin::Info-->
      <div class="d-flex flex-wrap justify-content-between my-5">
        <!--begin::Expert-->
        <div v-if="formation.user" class="min-w-125px py-3 me-7">
          <span class="font-noe-display-regular-italic fw-bold">
            <span class="fs-4 text-dark">Avec </span>
            <span class="fs-4 text-dark">{{ formation.user.name }}</span>
          </span>
        </div>
	</div>
        <!--end::Expert-->
        <!--begin::Button-->
        <div class="z-index-0">
          <button
            type="button"
            @click="addToCart(formation.id)"
            class="btn btn-icon z-index-3 formation-icon">
            <img src="/img/icon/arrow-dark.svg" alt="arrow">
          </button>
        </div>
        <!--end::Button-->
      </div>
      <!--end::Info-->
    </div>
    <!--end:: Card body-->
  </div>
  <!--end:: Card-->
</template>

<script>
import ApiService from "../../../services/api.service";
import {SET_CART} from "../../../services/store/cart.module";
import {useStore} from "vuex";
import {onMounted, ref} from "vue";

export default {
  name: 'FormationItem',
  props: ['formation'],
  setup() {
    const store = useStore()
    const icon = ref(null)

    const randomIcon = () => {
      const values = [1, 2, 3, 4, 5, 6, 7, 8]
      const index = Math.floor(Math.random()*values.length);
      return values[index];
    }

    onMounted(() => {
      icon.value = randomIcon()
    })

    const addToCart = (id) => {
      ApiService.post('/carts', {formation_id: id})
        .then((response) => {
          if(response.data.success) {
            store.commit(SET_CART, response.data.data)
          }
        })
    }

    return {
      icon,
      addToCart,
    }
  }
}
</script>
