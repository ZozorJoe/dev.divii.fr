<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <slot name="tool-bar"></slot>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
          <!--begin::Sidebar-->
          <Sidebar v-model="room"></Sidebar>
          <!--end::Sidebar-->
          <!--begin::Content-->
          <Content v-model="room"></Content>
          <!--end::Content-->
        </div>
        <!--end::Layout-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import Sidebar from "./Sidebar";
import Content from "./Content";
import {onMounted, ref, watch} from "vue";
import CountDown from "../video/CountDown";
import {useRoute} from "vue-router";
import ApiService from "../../services/api.service";
import {SET_ERRORS} from "../../services/store/form.module";

export default {
  name: 'Chat',
  components: {CountDown, Content, Sidebar},
  setup() {
    const route = useRoute()

    const room =  ref(null)

    const loadModel = (value) => {
      if(!value){
        return;
      }
      ApiService.get('/account/rooms/' + value)
        .then((response) => {
          if(response.data.success) {
            room.value = response.data.data
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }

    const id = ref(null)

    watch(() => id.value, (value) => loadModel(value))

    onMounted(() => { id.value = route.params.id })

    return {
      room
    }
  },
}
</script>
