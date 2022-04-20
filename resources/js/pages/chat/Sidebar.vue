<template>
  <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
    <!--begin::Contacts-->
    <div class="card card-flush">
      <!--begin::Card header-->
      <div class="card-header pt-7" id="kt_chat_rooms_header">
        <div class="w-100">
          <InputSearch v-model="search" />
        </div>
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="card-body pt-5" id="kt_chat_rooms_body">
        <!--begin::List-->
        <div class="scroll-y me-n5 pe-5 vh-100"
             id="kt_chat_rooms_scroll"
             data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}"
             data-kt-scroll-max-height="auto"
             data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_rooms_header"
             data-kt-scroll-wrappers="#kt_content, #kt_chat_rooms_body"
             data-kt-scroll-offset="0px">

          <div v-if="rooms.length">
            <!--begin::Room-->
            <div class="d-flex flex-stack py-4 px-5"
                 v-for="room in rooms"
                 :key="room.id"
                 :class="{'bg-light-warning': modelValue && room.id === modelValue.id}"
                 @click="$emit('update:modelValue', room)"
            >
              <!--begin::Details-->
              <div class="d-flex align-items-center">
                <!--begin::Avatar-->
                <div class="symbol-group">
                  <div class="symbol symbol-circle symbol-45px">
                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">{{ room.title.charAt(0).toUpperCase() }}</span>
                    <span v-if="false" class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></span>
                  </div>
                  <div v-if="room.latestMessage && room.latestMessage.user && room.latestMessage.user.name" class="symbol symbol-circle symbol-20px mt-8">
                    <div class="symbol-label fs-8 fw-bold text-success">{{ room.latestMessage.user.name.charAt(0).toUpperCase() }}</div>
                  </div>
                </div>
                <!--end::Avatar-->
                <!--begin::Details-->
                <div class="ms-5">
                  <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">{{ room.title }}</a>
                  <div v-if="room.latestMessage" class="fw-bold text-muted">{{ room.latestMessage.content }}</div>
                </div>
                <!--end::Details-->
              </div>
              <!--end::Details-->

              <!--begin::Lat seen-->
              <div class="d-flex flex-column align-items-end ms-2">
                <span class="text-muted fs-7 mb-1">{{ moment(room.updated_at).fromNow() }}</span>
              </div>
              <!--end::Lat seen-->
            </div>
            <!--end::Room-->
          </div>
          <div v-else class="d-flex flex-column flex-center h-100 fw-bolder fs-3">
            Aucun(e) cours et/ou formation trouvé(e)
          </div>
        </div>
        <!--end::List-->
      </div>
      <!--end::Card body-->
    </div>
    <!--end::Contacts-->
  </div>
</template>

<script>
import moment from "moment";
import {computed, nextTick, onMounted, ref, watch} from "vue";
import ApiService from "../../services/api.service";
import {useStore} from "vuex";

export default {
  name: 'Sidebar',
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(){
    const store = useStore()

    const page = ref(1)

    const search = ref(null)

    const models = ref({})

    const rooms = computed(() => {
      let all = [];
      const keys = Object.keys(models.value);
      keys.sort().forEach(key => {
        const data = models.value[key];
        all = [...all, ...data]
      })

      return all.sort((a, b) => {
        if(a.updated_at < b.updated_at) return 1
        if(a.updated_at > b.updated_at) return -1
        return 0
      }).filter((v, i, a) => {
        return (a.id !== v.id)
      });
    })

    const params = computed(() => {
      let data = {'page' : page.value}
      if(search.value){
        data['s'] = search.value
      }
      return data
    })

    const loadModels = () => {
      ApiService.get('/account/rooms', {params: params.value})
        .then((response) => {
          if(response.data.success){
            const curPage = response.data.meta.current_page
            models.value[curPage] = response.data.data
            if(curPage === 1){
              //nextTick(scrollBottom)
            }else{
              const lastPage = response.data.meta.last_page
              if(lastPage <= curPage){
                page.value = 1
              }
            }
          }
        })
    }

    onMounted(loadModels)

    watch(() => params.value, () => { loadModels() })

    const scrollTop = () => {
      $('#kt_chat_rooms_scroll').animate({scrollTop: 0}, "slow");
    }

    const hasListen = ref(false)
    const listen = (user) => {
      if(hasListen.value){
        return;
      }
      Echo.private('users.' + user.id)
        .listen('.message.created', (e) => {
          toastr.success(e.message.content);
          const room = rooms.value.find(item => item.id === e.message.room.id)
          if(room){
            room.updated_at = e.message.room.updated_at
            room.latestMessage = e.message
          }else{
            e.message.room.latestMessage = e.message
            rooms.value.unshift(e.message.room)
          }
          nextTick(scrollTop)
        })
      hasListen.value = true
    }

    const user = computed(() => store.getters.currentUser)
    watch(user, (value) => {
      if(value){
        listen(value)
      }
    })

    onMounted(() => {
      $("#kt_chat_rooms_scroll").scroll(function() {
        if($(this).get(0).scrollHeight - $(this).scrollTop() - $(this).height() === 0){
          page.value++
        }
      })
    })

    return {
      search,
      rooms,
      moment,
    }
  }
}
</script>
