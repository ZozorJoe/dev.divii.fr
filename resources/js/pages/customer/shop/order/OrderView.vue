<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">
        <!--begin::Orders-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
          <!--begin::Product List-->
          <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header">
              <div class="card-title">
                <h2>{{ $t('messages.orders.view') }} #{{ model.id }}</h2>
              </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

              <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                  <!--begin::Table head-->
                  <thead>
                  <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-175px">Elément</th>
                    <th class="min-w-70px text-end">Qté</th>
                    <th class="min-w-100px text-end">PU</th>
                    <th class="min-w-100px text-end">Total</th>
                  </tr>
                  </thead>
                  <!--end::Table head-->
                  <!--begin::Table body-->
                  <tbody class="fw-bold text-gray-600">
                  <!--begin::Products-->
                  <tr
                    v-for="item in model.items"
                    :key="`order-item-${item.id}`"
                  >
                    <!--begin::Product-->
                    <td>
                      <div v-if="item.formation" class="d-flex align-items-center">
                        <!--begin::Thumbnail-->
                        <router-link :to="{name:'customer.formations.view', params:{id: item.formation.id}}" class="symbol symbol-50px">
                          <span class="symbol-label" :style="`background-image:url(/f/image-${model.id}.jpg);`"></span>
                        </router-link>
                        <!--end::Thumbnail-->
                        <!--begin::Title-->
                        <div class="ms-5">
                          <router-link :to="{name:'customer.formations.view', params:{id: item.formation.id}}" class="fw-bolder text-gray-600 text-hover-primary">{{ item.formation.name }}</router-link>
                        </div>
                        <!--end::Title-->
                      </div>
                      <div v-else-if="item.product" class="d-flex align-items-center">
                        <!--begin::Title-->
                        <div class="ms-5">
                          <router-link :to="{name:'customer.products.view', params:{id: item.product.id}}" class="fw-bolder text-gray-600 text-hover-primary">{{ item.product.name }}</router-link>
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
            <!--end::Card body-->
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
        {title: 'dashboard', route: "customer.dashboard"},
        {title: 'orders', route: "customer.orders"},
        {title: 'messages.orders.view'},
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
      const params = {params:{with:'items.orderable,user'}}
      ApiService.show('/customer/orders/' + value, params, t('order'), initModel, store, t)
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
