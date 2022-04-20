<template>
  <!--begin::Content-->
  <div class="modal fade show" id="kt_modal_video" tabindex="-1" aria-modal="true" style="display: block;">
    <!--begin::Modal dialog-->


    <div v-if="model" class="modal-dialog modal-fullscreen">
      <Future v-if="duration > 0" :duration="duration" :model="model" />
      <CallingConsultation v-else-if="model.consultation" />
      <CallingFormation v-else-if="model.formation" />
    </div>
    <!--end::Modal dialog-->
  </div>
  <!--end::Content-->
</template>

<script>
import {compile, computed, onMounted, ref, watch} from "vue";
import CallingFormation from "./CallingFormation";
import CallingConsultation from "./CallingConsultation";
import Future from "./Future";
import {useStore} from "vuex";
import {SET_ROOM} from "../../services/store/room.module";
import ApiService from "../../services/api.service";
import {SET_ERRORS} from "../../services/store/form.module";
import {useRoute} from "vue-router";


export default {
  name: 'Video',
  components: {Future, CallingFormation, CallingConsultation},
  setup() {
    const store = useStore()

    const route = useRoute()

    const duration = ref(0)
    watch(() => duration.value, () => {
      setTimeout(() => { if(duration.value > 0){duration.value--;} }, 1000);
    })

    const jitsiOptions = computed(() => {
      return {
        roomName: "Crtv-meeting",
        width: 1265,
        height: 625,
        noSSL: false,
        userInfo: {
          email: "user@email.com",
          displayName: "User",
        },
        configOverwrite: {
          enableNoisyMicDetection: false,
        },
        interfaceConfigOverwrite: {
          SHOW_JITSI_WATERMARK: false,
          SHOW_WATERMARK_FOR_GUESTS: false,
          SHOW_CHROME_EXTENSION_BANNER: false,
        },
      };
    });

    const model = ref(null)
    const loadModel = () => {
      console.log('loadModel')
      store.commit(SET_ROOM, null)
      ApiService.get('/account/rooms/' + route.params.id)
        .then((response) => {
          if(response.data.success) {
            model.value = response.data.data
            store.commit(SET_ROOM, model.value)
            const value = Math.floor(moment(model.value.start_at).diff(moment()) / 1000)

            console.log("value", value);
            duration.value = value > 0 ? value : 0
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }
    onMounted(loadModel)

    return {
      model,
      duration,
      jitsiOptions  
    }
  },
}
</script>
