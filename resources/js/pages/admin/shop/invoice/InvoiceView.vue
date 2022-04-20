<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Button-->
      <a target="_blank" :href="`/account/invoices/${model.id}`" class="btn btn-sm btn-primary">Télécharger</a>
      <!--end::Button-->
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">
        <!--begin::Orders-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
          <!--begin::Product List-->
          <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <!--begin::Images-->
              <div class="row py-5">
                <div class="col-4">
                  <img alt="dots" src="/img/dots.png" class="dots">
                </div>
                <div class="col-4 text-center">
                  <img alt="logo" src="/img/logo-dark.svg" class="logo h-80px">
                </div>
                <div class="col-4"></div>
              </div>
              <!--end::Images-->

              <!--begin::Addresses-->
              <div class="row py-5">
                <div class="col-4">
                  <!--end::Text-->
                  <div class="fw-bolder fs-1 text-dark mb-5 text-uppercase">DIVII SAS</div>
                  <!--end::Text-->
                  <!--end::Description-->
                  <div class="fw-bold fs-2 text-dark">
                    907 846 232 RCS PARIS
                    <br>Siège social : 66 Rue de Clichy
                    <br>75009 Paris
                    <br>75009 Paris
                  </div>
                  <!--end::Description-->
                </div>
                <div class="col-4">

                </div>
                <div v-if="model.user" class="col-4">
                  <!--end::Text-->
                  <div class="fw-bolder fs-1 text-dark mb-5">{{ model.user.name }}</div>
                  <!--end::Text-->
                  <!--end::Description-->
                  <div class="fw-bold fs-2 text-dark">
                    {{ model.user.email }}
                  </div>
                  <!--end::Description-->
                </div>
              </div>
              <!--end::Addresses-->

              <div class="row">
                <div class="col-4">
                </div>
                <div class="col-8">
                  <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table fs-6 gy-5 mb-0">
                      <!--begin::Table head-->
                      <thead>
                      <tr class="text-start text-dark fw-bolder fs-1 border-dark border-bottom-5 border-top-5 gs-0">
                        <th class="min-w-150px text-end">Qté</th>
                        <th class="min-w-200px">DESCRIPTION</th>
                        <th class="min-w-150px text-end">Prix</th>
                      </tr>
                      </thead>
                      <!--end::Table head-->
                      <!--begin::Table body-->
                      <tbody class="fs-2 text-dark min-h-200px h-200px">
                      <!--begin::Products-->
                      <tr
                        v-for="item in model.items"
                        :key="`invoice-item-${item.id}`"
                      >
                        <!--begin::Quantity-->
                        <td class="text-end">{{ item.quantity }}</td>
                        <!--end::Quantity-->
                        <!--begin::Product-->
                        <td>
                          <div v-if="item.formation" class="d-flex align-items-center">
                            <router-link :to="{name:'admin.formations.view', params:{id: item.formation.id}}" class="fw-bolder text-dark text-hover-primary">{{ item.formation.name }}</router-link>
                          </div>
                          <div v-else-if="item.product" class="d-flex align-items-center">
                            <router-link :to="{name:'admin.products.view', params:{id: item.product.id}}" class="fw-bolder text-dark text-hover-primary">{{ item.product.name }}</router-link>
                          </div>
                          <div v-else-if="item.consultation" class="d-flex align-items-center">
                            <div class="fw-bolder text-dark text-hover-primary">{{ item.consultation.name }}</div>
                          </div>
                        </td>
                        <!--end::Product-->
                        <!--begin::Total-->
                        <td class="text-end">{{ item.row_total }} {{ item.currency }}</td>
                        <!--end::Total-->
                      </tr>
                      <!--end::Products-->
                      <!--end::Grand total-->
                      </tbody>
                      <!--end::Table head-->
                      <tfoot>
                      <!--begin::Grand total-->
                      <tr class="border-dark border-top-5">
                        <td colspan="2" class="fs-3 fw-boldest text-dark text-end">Montant dû</td>
                        <td class="text-dark fs-3 text-end">{{ model.total }} {{ model.currency }}</td>
                      </tr>
                      <!--end::Grand total-->
                      </tfoot>
                    </table>
                    <!--end::Table-->
                  </div>
                </div>
              </div>
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer fs-2 text-dark text-center">
              IBAN FR76 3000 3032 7000 0201 7056 005
              <br>BIC : SOGEFRPP
            </div>
            <!--end::Card footer-->
            </div>
          <!--end::Product List-->
        </div>
        <!--end::Orders-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {useRoute} from "vue-router";
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";
import {computed, onMounted, ref, watch} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import ApiService from "../../../../services/api.service";

export default {
  name: 'InvoiceView',
  setup(){
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'invoices', route: "admin.invoices"},
        {title: 'messages.invoices.view'},
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
      const params = {params:{with:'items.invoiceable,user'}}
      ApiService.show('/admin/invoices/' + value, params, t('invoice'), initModel, store, t)
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
