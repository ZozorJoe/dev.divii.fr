<template>
  <div class="d-flex align-items-center ms-1 ms-lg-3">
    <!--begin::Menu- wrapper-->
    <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px show menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
      <!--begin::Svg Icon-->
      <span class="svg-icon svg-icon-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
          <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"></path>
          <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"></path>
        </svg>
      </span>
      <!--end::Svg Icon-->
      <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
    </div>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" style="z-index: 105; position: fixed; inset: 0 auto auto 0; margin: 0; transform: translate(856px, 65px);" data-popper-placement="bottom-end">
      <!--begin::Items-->
      <div class="scroll-y mh-325px my-5 px-8">
        <template v-for="model in models" :key="model.id">
          <ServerCreated v-if="model.type === 'App\\Notifications\\ServerCreated'" :notification="model" />
        </template>
      </div>
      <!--end::Items-->

      <!--begin::View more-->
      <div class="py-3 text-center border-top">
        <a href="#" class="btn btn-color-gray-600 btn-active-color-primary" @click="loadMore">Load More
          <!--begin::Svg Icon-->
          <span class="svg-icon svg-icon-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
              </g>
            </svg>
          </span>
          <!--end::Svg Icon--></a>
      </div>
      <!--end::View more-->
    </div>
    <!--end::Menu-->
    <!--end::Menu wrapper-->
  </div>
</template>

<script>
import {useStore} from "vuex";
import {computed, ref, watch} from "vue";
import ApiService from "../../../services/api.service";
import ServerCreated from "./notification/ServerCreated";

export default {
  name: "KTNotifications",
  components: {ServerCreated},
  setup(){
    const store = useStore()

    const page = ref(1)

    const params = computed(() => {
      return {'page': page.value, 'per-page': 10}
    })

    const models = ref([])

    const loadModels = () => {
      ApiService.get('/account/notifications', {params: params.value})
        .then((response) => {
          if(response.data.success){
            if(page.value > 1){
              const old = models.value
              const data = response.data.data
              models.value = [...old, ...data]
            }else{
              models.value = response.data.data
            }
          }
        })
    }

    const loadMore = () => {
      page.value++
      loadModels()
    }

    const hasListen = ref(false)
    const listen = (user) => {
      if(!hasListen.value){
        Echo.private('users.' + user.id)
          .notification((notification) => {
            models.value.unshift(notification)
            toast(notification)
          })
        hasListen.value = true
      }
    }

    const toast = (value) => {
      toastr.success("New notification has been received!");
    }

    const user = computed(() => store.getters.currentUser)

    watch(user, (value) => {
      if(value){
        page.value = 1
        loadModels()
        listen(value)
      }
    })

    return {
      models,
      loadMore,
    }
  }
};
</script>
