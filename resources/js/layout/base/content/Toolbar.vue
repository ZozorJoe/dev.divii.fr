<template>
  <!--begin::Toolbar-->
  <div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack"><div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
      <!--begin::Title-->
      <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
        {{ $t(title) }}
        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
        <!--end::Separator-->
      </h1>

        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-dot fw-bold fs-7 my-1">
          <!--begin::Item-->
          <li class="breadcrumb-item" v-for="(breadcrumb, i) in breadcrumbs" :key="`${i}-${breadcrumb.id}`">
            <router-link
              v-if="breadcrumb.route"
              :key="i"
              :to="typeof breadcrumb.route === 'object' ? breadcrumb.route : {name: breadcrumb.route }"
              class="text-muted"
            >
              {{ $t(breadcrumb.title + '') }}
            </router-link>
            <span class="text-muted" :key="i" v-if="!breadcrumb.route">
              {{ $t(breadcrumb.title + '') }}
            </span>
          </li>
          <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
      <!--end::Title-->
    </div>
      <!--begin::Page title-->

      <!--end::Page title-->
      <!--begin::Actions-->
      <div class="d-flex align-items-center py-1" v-if="$slots.default">
        <slot></slot>
      </div>
      <!--end::Actions-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Toolbar-->
</template>

<script>
import {useStore} from "vuex";
import {computed} from "vue";

export default {
  name: "KtToolbar",
  setup(){
    const store = useStore()

    const breadcrumbs = computed(() => store.getters.breadcrumbs)
    const title = computed(() => store.getters.pageTitle + '')

    return {
      breadcrumbs,
      title
    }
  }
};
</script>
