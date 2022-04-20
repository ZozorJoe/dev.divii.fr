<template>
  <div>
    <template
      v-if="modelValue"
      v-for="message in messages"
      :key="message.id">
      <!--begin::Message(in)-->
      <div v-if="!isMine(message)" class="d-flex mb-10 justify-content-start" >
        <!--begin::Wrapper-->
        <div class="d-flex flex-column align-items-start">
          <!--begin::User-->
          <div class="d-flex align-items-center mb-2">
            <!--begin::Avatar-->
            <BaseAvatar v-model="message.user" />
            <!--end::Avatar-->
            <!--begin::Details-->
            <div class="ms-3">
              <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ message.user.name }}</a>
              <span class="text-muted fs-7 mb-1">{{ moment(message.created_at).fromNow() }}</span>
            </div>
            <!--end::Details-->
          </div>
          <!--end::User-->
          <!--begin::Text-->
          <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">
            {{  message.content }}
          </div>
          <!--end::Text-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Message(in)-->

      <!--begin::Message(out)-->
      <div v-else class="d-flex justify-content-end mb-10">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column align-items-end">
          <!--begin::User-->
          <div class="d-flex align-items-center mb-2">
            <!--begin::Details-->
            <div class="me-3">
              <span class="text-muted fs-7 mb-1">{{ moment(message.created_at).fromNow() }}</span>
              <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">Vous</a>
            </div>
            <!--end::Details-->
            <!--begin::Avatar-->
            <BaseAvatar class="symbol-35px" v-model="message.user" />
            <!--end::Avatar-->
          </div>
          <!--end::User-->
          <!--begin::Text-->
          <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">
            {{  message.content }}
          </div>
          <!--end::Text-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Message(out)-->

    </template>

    <div v-else class="card">
      <!--begin::Wrapper-->
      <div class="d-flex flex-column px-9">
        <!--begin::Section-->
        <div class="pt-10 pb-0">
          <!--begin::Title-->
          <h3 class="text-dark text-center fw-bolder">Sélectionner un groupe de chat</h3>
          <!--end::Title-->
          <!--begin::Action-->
          <div class="text-center mt-5 mb-9">
            <a href="/" class="btn btn-sm btn-primary px-6">Accueil</a>
          </div>
          <!--end::Action-->
        </div>
        <!--end::Section-->
      </div>
      <!--end::Wrapper-->
    </div>

    <audio ref="audio" preload="auto" class="sound-player" style="display:none;">
      <source src="/audio/call.mp3" />
      <embed src="/audio/call.mp3" hidden="true"/>
    </audio>
  </div>
</template>
<script>
import moment from "moment"
import ApiService from "../../../services/api.service";
import {computed, nextTick, onMounted, ref, toRefs, watch} from "vue";
import {useStore} from "vuex";
import BaseAvatar from "../../../components/utils/BaseAvatar";

export default {
  name: 'ContentBody',
  components: {BaseAvatar},
  props: {
    scrollId: {
      type: String,
      default: null,
    },
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const store = useStore()

    const page = ref(1)

    const models = ref({})

    const messages = computed(() => {
      let all = [];
      const keys = Object.keys(models.value);
      keys.sort().forEach(key => {
        const data = models.value[key];
        all = [...all, ...data]
      })
      return all.reverse();
    })

    const { modelValue } = toRefs(props)

    const url = ref(null)

    watch(() => modelValue.value, (value) => {
      if(value){
        url.value = '/account/rooms/' + value.id + '/messages'
      }
    })

    const params = computed(() => {
      return {'page': page.value, 'per-page': 7}
    })

    const loadModels = () => {
      if(!url.value) return;
      ApiService.get(url.value, {params: params.value})
        .then((response) => {
          if(response.data.success){
            const curPage = response.data.meta.current_page
            models.value[curPage] = response.data.data
            if(curPage === 1){
              nextTick(scrollBottom)
            }else{
              const lastPage = response.data.meta.last_page
              if(lastPage <= curPage){
                page.value = lastPage
              }
            }
          }
        })
    }

    const readMessage = (message) => {
      ApiService.put(url.value + '/' + message.id)
    }

    const scrollBottom = () => {
      const domElement = document.querySelector("#" + props.scrollId)
      const jqueryElement = $('#' + props.scrollId)
      jqueryElement.animate({scrollTop: domElement.scrollHeight}, "slow");
    }

    const audio = ref(null)
    const hasListen = ref(false)
    const listen = (roomId) => {
      if(hasListen.value){
        return;
      }
      console.log('listen', roomId)
      Echo.private('rooms.' + roomId)
        .listen('.message.created', (e) => {
          console.log('.message.created', e)
          if(!models.value[1]){
            models.value[1] = []
          }
          models.value[1].unshift(e.message)
          nextTick(scrollBottom)
          if(audio.value){
            audio.value.play()
          }
        })
      hasListen.value = true
    }

    const leave = (roomId) => {
      console.log('leave', roomId)
      Echo.leaveChannel('rooms.' + roomId)
    }

    const isMine = (model) => {
      return store.getters.currentUser && store.getters.currentUser.id === model.user_id
    }

    watch(() => modelValue.value, (value, oldValue) => {
      console.log('watch modelValue.value', value, oldValue)
      if(value) {
        listen(value.id)
      }
      if(oldValue) {
        leave(oldValue.id)
      }
    })

    watch(() => url.value, () => {
      models.value = []
      if(page.value > 1) {
        page.value = 1
      }else{
        loadModels()
      }
    })

    watch(() => page.value, () => {loadModels()} )

    onMounted(() => {
      $("#kt_chat_messenger_messages").scroll(function() {
        if($(this).scrollTop() === 0){
          page.value++
        }
      })
    })

    return {
      audio,
      modelValue,
      messages,
      isMine,
      moment,
    }
  }
}
</script>
