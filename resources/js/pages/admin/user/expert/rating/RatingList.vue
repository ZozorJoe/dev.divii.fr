<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Button-->
      <button
        type="button"
        @click="loadModels"
        class="btn btn-sm btn-flex btn-light fw-bolder me-2">
        {{ $t('refresh') }}
      </button>
      <!--end::Button-->
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <!--begin::Card-->
        <div class="card">

          <!--begin::Card body-->
          <div class="card-body pt-0">

            <div v-if="selected.length > 0">
              <button @click="handleMassDelete()" class="btn btn-sm btn-danger">
                {{ $t('delete') }} ({{ selected.length }})
              </button>
            </div>

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5">
              <!--begin::Table head-->
              <thead>
              <!--begin::Table row-->
              <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                  <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input" type="checkbox" v-model="selectAll" />
                  </div>
                </th>
                <th class="min-w-125px">{{ $t('value') }}</th>
                <th class="min-w-125px">{{ $t('status') }}</th>
                <th class="min-w-125px">{{ $t('user') }}</th>
                <th class="min-w-125px">{{ $t('expert') }}</th>
                <th class="min-w-125px">{{ $t('date') }}</th>
                <th class="text-end min-w-70px">{{ $t('actions') }}</th>
              </tr>
              <!--end::Table row-->
              </thead>
              <!--end::Table head-->
              <!--begin::Table body-->
              <tbody class="fw-bold text-gray-600" v-if="models && models.length">
              <tr v-for="model in models" :key="model.id" :id="`table-row-${model.id}`">
                <!--begin::Checkbox-->
                <td>
                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" v-model="selected" :value="model" />
                  </div>
                </td>
                <!--end::Checkbox-->
                <!--begin::Value=-->
                <td>{{ model.value }}</td>
                <!--end::Value-->
                <!--begin::Status=-->
                <td>
                  <span
                    class="badge"
                    :class="{
                      'badge-light-warning': model.status === 'ping',
                      'badge-light-primary': model.status === 'validated'
                    }">
                    {{ $t(model.status) }}
                  </span>
                </td>
                <!--end::Status-->
                <!--begin::User=-->
                <td>
                  <router-link
                    v-if="model.user"
                    :to="{name: 'admin.customers.view', params:{id: model.user.id}}"
                    class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-5">
                      <img :src="`/u/image-${model.user.id}.jpg`" alt="">
                      <span
                        :class="{'badge-success': model.user.online, 'badge-danger': !model.user.online}"
                        class="symbol-badge badge badge-circle w-10px h-10px top-100 start-100"></span>
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                      <span class="text-dark fw-bolder text-hover-primary fs-6">{{ model.user.name }}</span>
                      <span class="text-muted fw-bold text-muted d-block fs-7">{{ model.user.email }}</span>
                    </div>
                  </router-link>
                </td>
                <!--end::User=-->
                <!--begin::Expert=-->
                <td>
                  <router-link
                    v-if="model.expert"
                    :to="{name: 'admin.experts.view', params:{id: model.expert.id}}"
                    class="d-flex align-items-center">
                    <div class="symbol symbol-45px me-5">
                      <img :src="`/u/image-${model.expert.id}.jpg`" alt="">
                      <span
                        :class="{'badge-success': model.expert.online, 'badge-danger': !model.expert.online}"
                        class="symbol-badge badge badge-circle w-10px h-10px top-100 start-100"></span>
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                      <span class="text-dark fw-bolder text-hover-primary fs-6">{{ model.expert.name }}</span>
                      <span class="text-muted fw-bold text-muted d-block fs-7">{{ model.expert.email }}</span>
                    </div>
                  </router-link>
                </td>
                <!--end::Expert=-->
                <!--begin::Date=-->
                <td>
                  {{ $filters.formatDateTime(model.created_at) }}
                </td>
                <!--end::Date=-->

                <!--begin::Action=-->
                <td class="text-end">
                  <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions
                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <polygon points="0 0 24 0 24 24 0 24" />
                          <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                        </g>
                      </svg>
                    </span>
                    <!--end::Svg Icon--></a>
                  <!--begin::Menu-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a
                        v-if="model.status === 'ping'"
                        href="#"
                        @click="validate(model)"
                        class="menu-link text-success px-3">
                        {{ $t('validate') }}
                      </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" @click="handleDelete(model)" class="menu-link text-danger px-3">{{ $t('delete') }}</a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::Menu-->
                </td>
                <!--end::Action=-->
              </tr>
              </tbody>
              <!--end::Table body-->
            </table>
            <!--end::Table-->

            <Pagination v-model="page" @changePerPage="changePerPage" :meta="meta"></Pagination>
          </div>
          <!--end::Card body-->
        </div>
        <!--end::Card-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import ApiService from "../../../../../services/api.service";
import {SET_BREADCRUMB} from "../../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import {ref, onMounted, computed, watch, nextTick} from "vue";
import {useI18n} from "vue-i18n";

export default {
  name: 'RatingList',
  setup(){
    const store = useStore()
    const { t } = useI18n()

    const models = ref([])
    const selected = ref([])
    const selectAll = ref(false)
    const page = ref(1)
    const per_page = ref(null)
    const meta = ref(null)
    const search = ref(null)

    const params = computed(() => {
      let data = {'page' : page.value}
      if(per_page.value){
        data['per-page'] = per_page.value
      }
      if(search.value){
        data['s'] = search.value
      }
      data['with'] = 'user,expert'
      return data
    })

    const changePerPage = (value) => {
      per_page.value = value
    }

    const loadModels = () => {
      ApiService.get('/admin/experts/ratings', {params: params.value})
        .then(({data}) => {
          if(data.success) {
            models.value = data.data
            meta.value = data.meta
          }
          nextTick(function(){ KTMenu.createInstances(); });
        })
    }

    const handleDelete = (model) => {
      Swal.fire({
        title: t('messages.confirm.delete'),
        icon: "error",
        showCancelButton: true,
        cancelButtonText: t('cancel'),
        confirmButtonText: t('yes'),
      }).then((result) => {
        if (result.isConfirmed) {
          ApiService.delete('/admin/experts/ratings/' + model.id)
            .then(response => {
              if(response.data.success){
                loadModels()
              }
            })
        }
      })
    }

    const handleMassDelete = () => {
      Swal.fire({
        title: t('messages.confirm.mass_delete'),
        icon: "error",
        showCancelButton: true,
        cancelButtonText: t('cancel'),
        confirmButtonText: t('yes'),
      }).then((result) => {
        if (result.isConfirmed) {
          let data = []
          selected.value.forEach(function (item){
            data.push(item.id)
          })
          ApiService.delete('/admin/experts/ratings', {data: {customers: data}})
            .then(response => {
              if(response.data.success){
                selectAll.value = false
                selected.value = []
                loadModels()
              }
            })
        }
      })
    }

    onMounted(() => {
      loadModels()
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'ratings'}
      ])
    })

    watch(() => params.value, () => { loadModels() })

    watch(selectAll, (value) => {
      selected.value = []
      if(value){
        selected.value = [...models.value]
      }
    })

    const refuse = (model) => {
      ApiService.put('/admin/experts/ratings/' + model.id + "/refused")
        .then(({data}) => {
          if(data.success){
            loadModels()
          }
        })
    }

    const validate = (model) => {
      ApiService.put('/admin/experts/ratings/' + model.id + "/validated")
        .then(({data}) => {
          if(data.success){
            loadModels()
          }
        })
    }

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModels() })

    return {
      models,
      selected,
      selectAll,
      page,
      meta,
      search,
      loadModels,
      handleDelete,
      handleMassDelete,
      changePerPage,
      refuse,
      validate,
    }
  }
}
</script>
