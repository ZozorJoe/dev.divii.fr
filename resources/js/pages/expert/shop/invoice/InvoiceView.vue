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
                  <div class="fw-bolder fs-3 text-gray-800 mb-5">DIVII SAS</div>
                  <!--end::Text-->
                  <!--end::Description-->
                  <div class="fw-bold fs-4 text-gray-600">
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
                  <div class="fw-bolder fs-3 text-gray-800 mb-5">{{ model.user.name }}</div>
                  <!--end::Text-->
                  <!--end::Description-->
                  <div class="fw-bold fs-4 text-gray-600">
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                      <!--begin::Table head-->
                      <thead>
                      <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-175px">Elément</th>
                        <th class="min-w-70px text-end">Qté</th>
                        <th class="min-w-100px text-end">PU</th>
                        <th class="min-w-100px w-100 text-end">Total</th>
                      </tr>
                      </thead>
                      <!--end::Table head-->
                      <!--begin::Table body-->
                      <tbody class="fw-bold text-gray-600">
                      <!--begin::Products-->
                      <tr
                        v-for="item in model.items"
                        :key="`invoice-item-${item.id}`"
                      >
                        <!--begin::Product-->
                        <td>
                          <div v-if="item.formation" class="d-flex align-items-center">
                            <!--begin::Thumbnail-->
                            <div class="symbol symbol-50px">
                              <span class="symbol-label" :style="`background-image:url(/f/image-${model.id}.jpg);`"></span>
                            </div>
                            <!--end::Thumbnail-->
                            <!--begin::Title-->
                            <div class="ms-5">
                              <div class="fw-bolder text-gray-600 text-hover-primary">{{ item.formation.name }}</div>
                            </div>
                            <!--end::Title-->
                          </div>
                          <div v-else-if="item.product" class="d-flex align-items-center">
                            <!--begin::Title-->
                            <div class="ms-5">
                              <div class="fw-bolder text-gray-600 text-hover-primary">{{ item.product.name }}</div>
                            </div>
                            <!--end::Title-->
                          </div>
                          <div v-else-if="item.consultation" class="d-flex align-items-center">
                            <!--begin::Title-->
                            <div>
                              <div class="fw-bolder text-gray-600 text-hover-primary">{{ item.consultation.name }}</div>
                            </div>
                            <!--end::Title-->
                          </div>
                          <div v-else-if="item.room" class="d-flex align-items-center">
                            <!--begin::Title-->
                            <div>
                              <div class="fw-bolder text-gray-600 text-hover-primary">{{ item.room.title }} (#{{ item.room.id }})</div>
                            </div>
                            <!--end::Title-->
                          </div>
                        </td>
                        <!--end::Product-->
                        <!--begin::Quantity-->
                        <td class="text-end">{{ item.quantity }}</td>
                        <!--end::Quantity-->
                        <!--begin::Price-->
                        <td class="text-end">{{ item.price }} {{ item.currency }}</td>
                        <!--end::Price-->
                        <!--begin::Total-->
                        <td class="text-end">{{ item.row_total }} {{ item.currency }}</td>
                        <!--end::Total-->
                      </tr>
                      <!--end::Products-->
                      <!--begin::Subtotal-->
                      <tr>
                        <td colspan="4" class="text-end">{{ $t('sub_total') }}</td>
                        <td class="text-end">{{ model.sub_total }} {{ model.currency }}</td>
                      </tr>
                      <!--end::Subtotal-->
                      <!--begin::VAT-->
                      <tr>
                        <td colspan="4" class="text-end">{{ $t('vat') }}</td>
                        <td class="text-end">{{ model.vat_total }} {{ model.currency }}</td>
                      </tr>
                      <!--end::VAT-->
                      <!--begin::Grand total-->
                      <tr>
                        <td colspan="4" class="fs-3 text-dark text-end">{{ $t('total') }}</td>
                        <td class="text-dark fs-3 fw-boldest text-end">{{ model.total }} {{ model.currency }}</td>
                      </tr>
                      <!--end::Grand total-->
                      </tbody>
                      <!--end::Table head-->
                    </table>
                    <!--end::Table-->
                  </div>
                </div>
              </div>
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer text-center">
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
  name: 'OrderView',
  setup(){
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'invoices', route: "expert.invoices"},
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
      ApiService.show('/expert/invoices/' + value, params, t('invoice'), initModel, store, t)
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
