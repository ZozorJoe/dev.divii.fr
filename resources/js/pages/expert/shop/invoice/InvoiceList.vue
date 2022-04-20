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

          <!--begin::Card header-->
          <div class="card-header border-0 pt-6">

            <!--begin::Card title-->
            <div class="card-title">
              <InputSearch v-model="search" />
            </div>
            <!--begin::Card title-->
          </div>
          <!--end::Card header-->

          <!--begin::Card body-->
          <div class="card-body pt-0">

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5">
              <!--begin::Table head-->
              <thead>
              <!--begin::Table row-->
              <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                <th>{{ $t('reference') }}</th>
                <th>{{ $t('total') }}</th>
                <th>{{ $t('date') }}</th>
                <th>{{ $t('status') }}</th>
                <th class="text-end min-w-70px">{{ $t('actions') }}</th>
              </tr>
              <!--end::Table row-->
              </thead>
              <!--end::Table head-->
              <!--begin::Table body-->
              <tbody class="fw-bold text-gray-600" v-if="models && models.length">
              <tr v-for="model in models" :key="model.id" :id="`table-row-${model.id}`">
                <!--begin::reference=-->
                <td>
                  {{ model.reference }}
                </td>
                <!--end::reference=-->
                <!--begin::Total=-->
                <td>
                  {{ model.total }} {{ model.currency }}
                </td>
                <!--end::Total=-->
                <!--begin::Date=-->
                <td>
                  {{ $filters.formatDateTime(model.created_at) }}
                </td>
                <!--end::Date=-->
                <!--begin::Status=-->
                <td>
                  <span
                    class="badge"
                    :class="{
                     'badge-light-danger': model.status==='ping',
                     'badge-light-primary': model.status==='validated',
                     'badge-light-warning': model.status==='refused',
                     'badge-light-success': model.status==='complete',
                    }">
                    {{ $t(model.status) }}
                  </span>

                </td>
                <!--end::Status=-->

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
                    <!--end::Svg Icon-->
                  </a>
                  <!--begin::Menu-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <router-link
                        :to="{name: 'expert.invoices.view', params: {id: model.id}}"
                        class="menu-link px-3">
                        {{ $t('view') }}
                      </router-link>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div
                      v-if="model.status === 'ping'"
                      class="menu-item px-3">
                      <a
                        href="#"
                        @click="validateInvoice(model)"
                        class="menu-link text-success px-3">
                        {{ $t('validate_invoice') }}
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
import KtToolbar from "../../../../layout/base/content/Toolbar";
import InputSearch from "../../../../components/form/InputSearch";
import Pagination from "../../../../components/utils/Pagination";
import ApiService from "../../../../services/api.service";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {ref, onMounted, computed, watch, nextTick} from "vue";

export default {
  name: 'InvoiceList',
  components: {Pagination, InputSearch, KtToolbar},
  setup(){
    const store = useStore()

    const models = ref([])
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
      data['with'] = 'user,order'
      return data
    })

    const changePerPage = (value) => {
      per_page.value = value
    }

    const loadModels = () => {
      ApiService.get('/expert/invoices', {params: params.value})
        .then(({data}) => {
          if(data.success) {
            models.value = data.data
            meta.value = data.meta
          }
          nextTick(function(){ KTMenu.createInstances(); });
        })
    }

    onMounted(() => {
      loadModels()
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'invoices_validated'}
      ])
    })

    watch(() => params.value, () => { loadModels() })

    const validateInvoice = (model) => {
      ApiService.put('/expert/invoices/' + model.id + "/validated")
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
      page,
      meta,
      search,
      loadModels,
      changePerPage,
      validateInvoice,
    }
  }
}
</script>
