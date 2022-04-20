<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <div class="card mb-5 mb-xl-8">
          <!--begin::Card body-->
          <div class="card-body">
            <!--begin::User Info-->
            <div class="d-flex flex-column py-5">
              <!--begin::Avatar-->
              <div class="symbol symbol-100px symbol-circle mb-7">
                <img :src="`/u/image-${model.id}.jpg`" alt="image">
              </div>
              <!--end::Avatar-->
            </div>
            <!--end::User Info-->

            <!--begin::Info-->
            <div class="pb-5 fs-6">
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('first_name') }}</div>
              <div class="text-gray-600">{{ model.first_name }}</div>
              <!--begin::Details item-->
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('last_name') }}</div>
              <div class="text-gray-600">{{ model.last_name }}</div>
              <!--begin::Details item-->
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('email') }}</div>
              <div class="text-gray-600">
                <a href="#" class="text-gray-600 text-hover-primary">{{ model.email }}</a>
              </div>
              <!--begin::Details item-->
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('birthday') }}</div>
              <div class="text-gray-600">{{ model.birthday ? model.birthday : 'Non renseigné' }}</div>
              <!--begin::Details item-->
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('birth_hour') }}</div>
              <div class="text-gray-600">{{ model.birthday ? model.birth_hour : 'Non renseigné' }}</div>
              <!--begin::Details item-->
              <!--begin::Details item-->
              <div class="fw-bolder mt-5">{{ $t('birth_place') }}</div>
              <div class="text-gray-600">{{ model.birthday ? model.birth_place : 'Non renseigné' }}</div>
              <!--begin::Details item-->
            </div>
            <!--end::Info-->

          </div>
          <!--end::Card body-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {useStore} from "vuex";
import {computed, onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import {useI18n} from "vue-i18n";
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";
import ApiService from "../../../services/api.service";

export default {
  name: 'UserView',
  setup(){
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'messages.customers.view'},
      ])
    })

    const model = ref(null)
    const id = ref(route.params.id)
    const init = () => {
      model.value = null
      loadModel(id.value)
    }
    const loadModel = (value) => {
      if(!value){ return; }
      const params = {params:{with:''}}
      ApiService.show('/expert/users/' + value, params, t('customer'), initModel, store, t)
    }
    watch(() => id.value, () => { init() })
    onMounted(init)

    const initModel = (value) => {
      model.value = value
    }

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    return {
      model,
    }
  }
}
</script>
