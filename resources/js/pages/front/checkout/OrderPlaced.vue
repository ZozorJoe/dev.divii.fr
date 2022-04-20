<template>
  <!--begin::Card-->
  <div class="bg-grad-4"></div>
  <div class="card">
    <!--begin::Card body-->
    <div class="card-body p-0">
      <!--begin::Wrapper-->
      <div class="card-px text-center py-20 my-10">
        <!--begin::Title-->
        <h2 class="fs-2x fw-bolder mb-10">{{ $t('messages.order.placed.title') }}</h2>
        <!--end::Title-->
        <!--begin::Description-->
        <p class="text-gray-400 fs-4 fw-bold mb-10">{{ $t('messages.order.placed.description')}}</p>
        <!--end::Description-->
        <!--begin::Action-->
        <router-link
          :to="{name: 'home'}"
          class="btn btn-primary">
          {{ $t('home') }}
        </router-link>
        <!--end::Action-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
</template>

<script>
export default {
  name: "OrderPlaced"
};
</script>
