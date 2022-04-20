<template>
  <!--begin::Card-->
  <div class="bg-grad-4"></div>
  <div class="card">
    <!--begin::Card body-->
    <div class="card-body p-0">
      <!--begin::Wrapper-->
      <div class="card-px text-center py-20 my-10">
        <!--begin::Title-->
        <h2 class="fs-2x fw-bolder mb-10 canela-thin-italic">{{ $t('messages.empty.cart.title') }}</h2>
        <!--end::Title-->
        <!--begin::Description-->
        <p class="text-black fs-4 fw-bold mb-10">{{ $t('messages.empty.cart.description')}}</p>
        <!--end::Description-->
        <!--begin::Action-->
        <router-link
          :to="{name: 'home'}"
          class="btn fiche-btn bg-yellow">
          {{ $t('home') }}
        </router-link>
        <!--end::Action-->
      </div>
      <!--end::Wrapper-->
      <!--begin::Illustration-->
      <div class="text-center px-4">
        <img class="mw-100 mh-300px" alt="" src="/img/empty-cart.png">
      </div>
      <!--end::Illustration-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
</template>

<script>
export default {
  name: "EmptyCart"
};
</script>
