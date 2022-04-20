<template>
  <!--begin::Modal content-->
  <div class="modal-content rounded">

    <!--begin::Modal header-->
    <div class="modal-header border-0 pt-1 pb-1 mb-1">
      <div></div>

      <div class="d-flex flex-center">
        <!--begin::Chat Button -->
        <ChatDrawerButton />
        <!--end::Chat Button -->
      </div>
    </div>
    <!--end::Modal header-->

    <!--begin::Modal body-->
    <div class="modal-body pt-0 pb-15 px-5 px-xl-20 d-flex flex-center flex-column">
      <div class="d-flex flex-center flex-column p-9">
        <!--begin::Wrapper-->
        <div v-if="model.user" class="mb-5">
          <!--begin::Avatar-->
          <div class="symbol symbol-75px symbol-circle">
            <img alt="Pic" :src="`/u/image-${model.user.id}.jpg`">
          </div>
          <!--end::Avatar-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Name-->
        <a v-if="model.user" href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">{{ model.user.name }}</a>
        <!--end::Name-->

        <!--begin::Position-->
        <div v-if="model.user && model.user.disciplines && model.user.disciplines.length" class="fw-bold text-gray-400 mb-6">{{ model.user.disciplines[0].name }}</div>
        <!--end::Position-->

        <!--begin::Heading-->
        <div class="text-center mb-13">
          <!--begin::Title-->
          <h1 class="mb-3">{{ model.title }}</h1>
          <!--end::Title-->

          <CountDown :duration="duration" />

        </div>
        <!--end::Heading-->

        <!--begin::Link-->
        <div class="d-flex align-items-center gap-2 gap-lg-3">
          <a href="/auth/login" class="btn btn-flex btn-light btn-active-primary fw-bolder">
            Retours
          </a>
        </div>
        <!--end::Link-->

      </div>
    </div>
    <!--end::Modal body-->

  </div>
  <!--end::Modal content-->
</template>

<script>
import CountDown from "./CountDown";
import ChatDrawerButton from "../../components/utils/ChatDrawerButton";

export default {
  name: 'Future',
  components: {ChatDrawerButton, CountDown},
  props:['duration', 'model']
}
</script>
