<template>
    <!--begin::Card body-->
    <div class="card-body pt-0">

      <div class="row">
        <div class="col-3">
          <InputSearch v-model="search" />
        </div>
      </div>

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
          <th v-if="false" class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
              <input class="form-check-input" type="checkbox" v-model="selectAll" />
            </div>
          </th>
          <th>{{ $t('formation') }}</th>
          <th>{{ $t('expert') }}</th>
          <th>{{ $t('status') }}</th>
          <th>{{ $t('start_at') }}</th>
          <th>{{ $t('end_at') }}</th>
          <th class="text-end min-w-70px">{{ $t('actions') }}</th>
        </tr>
        <!--end::Table row-->
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-bold text-gray-600" v-if="models && models.length">
        <tr v-for="model in models" :key="model.id" :id="`table-row-${model.id}`">
          <!--begin::Checkbox-->
          <td v-if="false">
            <div class="form-check form-check-sm form-check-custom form-check-solid">
              <input class="form-check-input" type="checkbox" v-model="selected" :value="model" />
            </div>
          </td>
          <!--end::Checkbox-->
          <!--begin::Formation=-->
          <td>
            <div
              v-if="model.formation"
              class="d-flex align-items-center">
              <div class="symbol symbol-45px me-5">
                <img :src="`/f/image-${model.formation.id}.jpg`" alt="">
              </div>
              <div class="d-flex justify-content-start flex-column">
                <span class="text-dark fw-bolder text-hover-primary fs-6">{{ model.formation.name }}</span>
              </div>
            </div>
          </td>
          <!--end::Formation=-->
          <!--begin::Expert=-->
          <td>
            <div
              v-if="model.expert"
              class="d-flex align-items-center">
              <div class="symbol symbol-45px me-5">
                <img :src="`/u/image-${model.expert.id}.jpg`" alt="">
              </div>
              <div class="d-flex justify-content-start flex-column">
                <span class="text-dark fw-bolder text-hover-primary fs-6">{{ model.expert.name }}</span>
                <span class="text-muted fw-bold text-muted d-block fs-7">{{ model.expert.email }}</span>
              </div>
            </div>
          </td>
          <!--end::Expert=-->
          <!--begin::Status=-->
          <td>
            <span
              v-if="model.status"
              :class="{
                'badge-light-info': model.status === 'ping',
                'badge-light-warning': model.status === 'processing',
                'badge-light-primary': model.status === 'validated',
                'badge-light-success': model.status === 'complete',
                'badge-light-danger': model.status === 'canceled' || model.status === 'refused'
              }"
              class="badge">
              {{ $t('messages.status.' + model.status) }}
            </span>
          </td>
          <!--end::Status=-->
          <!--begin::Start At=-->
          <td>
            <span :class="{
              'text-black': $filters.isBefore(model.start_at),
              'text-success' : $filters.isAfter(model.start_at),
            }">
              {{ $filters.formatDateTime(model.start_at) }}
            </span>

          </td>
          <!--end::Start At=-->
          <!--begin::End At=-->
          <td>
            <span :class="{
              'text-danger': $filters.isBefore(model.end_at),
              'text-success' : $filters.isAfter(model.end_at),
            }">
              {{ $filters.formatDateTime(model.end_at) }}
            </span>
          </td>
          <!--end::End At=-->

          <!--begin::Action=-->
          <td class="text-end">
            <a v-if="model.status === 'validated'" href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions
              <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
              <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                  </g>
                </svg>
              </span>
              <!--end::Svg Icon-->
            </a>
            <!--begin::Menu-->
            <div v-if="model.status === 'validated'" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
              <!--begin::Menu item-->
              <div class="menu-item px-3">
                <router-link
                  target="_blank"
                  :to="{name:'account.video', params:{id:model.id}}"
                  class="menu-link text-success px-3">
                  Ouvrir la formation
                </router-link>
              </div>
              <!--end::Menu item-->
              <!--begin::Menu item-->
              <div
                v-if="cancelable"
                class="menu-item px-3">
                <a
                  href="#"
                  @click="openCancelModal(model)"
                  class="menu-link text-warning px-3">
                  {{ $t('cancel') }}
                </a>
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
</template>

<script>
import KtToolbar from "../../../../layout/base/content/Toolbar";
import InputSearch from "../../../../components/form/InputSearch";
import Pagination from "../../../../components/utils/Pagination";
import ApiService from "../../../../services/api.service";
import {ref, onMounted, computed, watch, nextTick, getCurrentInstance} from "vue";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";

export default {
  name: 'FormationList',
  components: {Pagination, InputSearch, KtToolbar},
  props:['filter', 'cancelable'],
  setup(props){
    const store = useStore()
    const { t } = useI18n()

    const models = ref([])
    const selected = ref([])
    const selectAll = ref(false)
    const page = ref(1)
    const per_page = ref(null)
    const meta = ref(null)
    const search = ref(null)

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModels() })

    const params = computed(() => {
      let data = {'page' : page.value}
      if(per_page.value){
        data['per-page'] = per_page.value
      }
      if(search.value){
        data['s'] = search.value
      }
      data['with'] = 'customers,expert'
      data['filter'] = props.filter
      data['timezone'] = $timezone.value
      return data
    })

    const changePerPage = (value) => {
      per_page.value = value
    }

    const loadModels = () => {
      ApiService.get('/customer/sale/formations', {params: params.value})
        .then(({data}) => {
          if(data.success) {
            models.value = data.data
            meta.value = data.meta
          }
          nextTick(function(){ KTMenu.createInstances(); });
        })
    }
    onMounted(loadModels)

    const handleDelete = (model) => {
      Swal.fire({
        title: t('messages.confirm.delete'),
        icon: "error",
        showCancelButton: true,
        cancelButtonText: t('cancel'),
        confirmButtonText: t('yes'),
      }).then((result) => {
        if (result.isConfirmed) {
          ApiService.delete('/customer/sale/formations/' + model.id)
            .then(response => {
              if(response.data.success){
                loadModels()
              }
            })
        }
      })
    }

    const model = ref(null)
    const openCancelModal = (value) => {
      model.value = {
        room_id: value.id,
        status: 'canceled',
        content: null,
      }
    }
    const closeCancelModal = () => {
      model.value = null
    }
    const handleCancel = () => {
      const data = model.value
      console.log(model.value)
      ApiService.update('/customer/sale/formations/' + data.room_id, data)
        .then(response => {
          if(response.data.success){
            loadModels()
          }
        })
        .finally(() => {
          closeCancelModal()
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
          ApiService.delete('/customer/sale/formations', {data: {formations: data}})
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

    watch(() => params.value, () => { loadModels() })

    watch(selectAll, (value) => {
      selected.value = []
      if(value){
        selected.value = [...models.value]
      }
    })

    return {
      model,
      models,
      selected,
      selectAll,
      page,
      meta,
      search,
      loadModels,
      handleDelete,
      openCancelModal,
      closeCancelModal,
      handleCancel,
      handleMassDelete,
      changePerPage,
    }
  }
}
</script>
