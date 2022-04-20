<template>

  <div v-if="discipline" class="card border-hover-primary">

    <!--begin:: Card body-->
    <div class="card-body overlay p-5">

      <!--begin::Image-->
      <div
        class="discipline-bg overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover min-h-200px position-relative"
        :style="`background-image:url('/d/image-${discipline.id}.jpg')`">
        </div>
      <!--end::Image-->

      <!--begin::Link-->
      <router-link
      :to="{name: 'front.disciplines.view', params: {id: discipline.id}}"
        class="overlay-layer front" :style="`background-color:${discipline.background_color};`">
        <img alt="icon" :src="`/d/picto-${discipline.id}.jpg`" class="w-50">
      </router-link>
      <!--end::Link-->

      <!--begin::Name-->
      <div class="discipline-description d-flex flex-column ">
        <span class="discipline-name text-dark text-hover-primary">
          {{ discipline.name }}
        </span>
        <span class="discipline-expert-count text-muted text-muted d-block">
          {{ $tc('count.experts', discipline.users_count) }}
        </span>
        <img alt="icon" :src="`/d/picto-${discipline.id}.jpg`" class="position-absolute discipline-icon">
      </div>
      <!--end::Name-->

    </div>
    <!--end:: Card body-->
  </div>
</template>

<script>

import {onMounted, ref} from "vue";

export default {
  name: 'DisciplineItem',
  props: ['discipline'],
}
</script>
