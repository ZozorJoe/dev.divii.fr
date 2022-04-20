<template>
  <!--begin::Item-->
  <div class="d-flex flex-stack py-4">
    <!--begin::Section-->
    <div class="d-flex align-items-center me-2">
      <!--begin::Code-->
      <span class="w-70px badge me-4" :class="`badge-light-${type}`">200 OK</span>
      <!--end::Code-->
      <!--begin::Title-->
      <a href="#" class="text-gray-800 text-hover-primary fw-bold">{{ notification.data.title }}</a>
      <!--end::Title-->
    </div>
    <!--end::Section-->
    <!--begin::Label-->
    <span class="badge badge-light fs-8">{{ moment(notification.created_at).fromNow() }}</span>
    <!--end::Label-->
  </div>
  <!--end::Item-->
</template>

<script>

import moment from "moment"
import {ref} from "vue";

export default {
  name: "ServerCreated",
  props: ['notification'],
  setup(props) {
    const type = ref(props.notification.data.type)
    return {
      moment,
      type
    }
  }
};
</script>
