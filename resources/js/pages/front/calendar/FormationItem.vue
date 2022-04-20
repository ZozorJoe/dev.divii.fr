<template>
  <!--begin:: Card-->
  <router-link
    :to="{name: 'front.formations.view', params: {id: formation.id}}"
    class="card border-hover-primary h-100">
    <!--begin:: Card body-->
    <div class="card-body p-5">

      <!--begin::Image-->
      <div
        class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover h-100px h-xxl-150px position-relative"
         :style="`background-image:url('/f/image-${formation.id}.jpg')`">
        <div
          v-if="formation.start_at"
          class="position-absolute top-100 translate-middle w-40px h-40px w-xl-50px h-xl-50px w-xxl-60px h-xxl-60px radius-50 font-moche-regular fw-normal text-center"
          :style="`right: -25px;background-color:${formation.background_color};`">
          <div class="w-100 fs-6 fs-xl-4 fs-xxl-2 mt-2">{{ $filters.formatDay(formation.start_at)}}</div>
          <div class="w-100 fs-10 fs-xl-9 fs-xxl-7 mt-n2 text-uppercase">{{ $filters.formatMonth(formation.start_at)}}</div>
        </div>
      </div>
      <!--end::Image-->

      <!--begin::Name-->
      <div class="text-start formation-name">
        <div class="canela-regular">
          {{ formation.name }}
        </div>
      </div>
      <!--end::Name-->

      <!--begin::Info-->
      <div class="d-flex flex-wrap justify-content-between my-5">
        <!--begin::Expert-->
        <div v-if="formation.user" class="py-3 text-start formation-name-b">
          <span class="canela-regular-italic">
            <span class="fs-8 fs-xl-6 fs-xxl-4 text-dark">Avec </span>
            <span class="fs-8 fs-xl-6 fs-xxl-4 text-dark">{{ formation.user.first_name }}</span>
          </span>
        </div>
        <!--end::Expert-->
        <!--begin::Button-->
        <div class="z-index-0">
          <div
            class="btn btn-icon add-to-c">
            <img src="/img/icon/arrow-dark.svg" alt="arrow">
          </div>
        </div>
        <!--end::Button-->
      </div>
      <!--end::Info-->
    </div>
    <!--end:: Card body-->
  </router-link>
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
