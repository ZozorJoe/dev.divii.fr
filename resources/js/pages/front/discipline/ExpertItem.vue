<template>
  <!--begin::Card-->
  <div v-if="expert" class="card border-hover-primary">
    <!--begin:: Card body-->
    <div class="card-body overlay p-5 ">

      <!--begin::Image-->
      <div
        class="discipline-bg overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover min-h-200px position-relative"
        :style="`background-image:url('/u/image-${expert.id}.jpg')`">
      </div>
      <!--end::Image-->

      <!--begin::Link-->
      <router-link
        :to="{name: 'front.disciplines.experts.view', params: {expert: expert.id}}"
        class="overlay-layer front" :style="`background-color:${expert.background_color};`">
        <img alt="icon" :src="`/u/picto-${expert.id}.jpg`" class="w-50">
      </router-link>
      <!--end::Link-->

      <!--begin::Name-->
      <div class="discipline-description d-flex flex-column mt-2">
        <div class="expert-name text-dark text-hover-primary italic-noe24">
          <span v-if="expert.available" class="mr-2 z-index-0 bullet bullet-dot bg-success h-10px w-10px translate-middle"></span>
          {{ expert.first_name }}
        </div>
        <img alt="icon" :src="`/u/picto-${expert.id}.jpg`" class="position-absolute  discipline-icon">
      </div>
      <!--end::Name-->

    </div>
    <!--end:: Card body-->
  </div>
  <!--end::Card-->
</template>

<script>
import {onMounted, ref} from "vue";

export default {
  name: 'ExpertItem',
  props: ['expert']
}
</script>
