<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <!--begin::Card-->
        <div class="card">

          <!--begin::Header-->
          <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bolder fs-3 mb-1">Mes consultations</span>
            </h3>
            <div class="card-toolbar">
              <ul class="nav">
                <li class="nav-item">
                  <router-link :to="{name:'customer.sale.consultations'}" :class="{'active': isActive('customer.sale.consultations')}" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1">Aujourd’hui</router-link>
                </li>
                <li class="nav-item">
                  <router-link :to="{name:'customer.sale.consultations.past'}" :class="{'active': isActive('customer.sale.consultations.past')}" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1">RDV passées</router-link>
                </li>
                <li class="nav-item">
                  <router-link :to="{name:'customer.sale.consultations.future'}" :class="{'active': isActive('customer.sale.consultations.future')}" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1">RDV futurs</router-link>
                </li>
                <li class="nav-item">
                  <router-link :to="{name:'customer.sale.consultations.agenda'}" :class="{'active': isActive('customer.sale.consultations.agenda')}" class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bolder px-4 me-1">Agenda</router-link>
                </li>
              </ul>
            </div>
          </div>
          <!--end::Header-->

          <router-view />
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
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import {useRoute} from "vue-router";

export default {
  name: 'ConsultationList',
  components: {Pagination, InputSearch, KtToolbar},
  setup(){
    const route = useRoute()
    const store = useStore()
    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "customer.dashboard"},
        {title: 'consultations'}
      ])
    })

    const isActive = (name) => {
      return route.name === name;
    }

    return {
      isActive,
    }
  }
}
</script>
