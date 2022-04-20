<template>
  <!--begin::Chat drawer-->
  <div id="kt_drawer_chat"
       class="bg-body drawer drawer-end"
       data-kt-drawer="true"
       data-kt-drawer-name="chat"
       data-kt-drawer-activate="true"
       data-kt-drawer-overlay="true"
       data-kt-drawer-width="{default:'300px', 'md': '500px'}"
       data-kt-drawer-direction="end"
       data-kt-drawer-toggle="#kt_drawer_chat_toggle"
       data-kt-drawer-close="#kt_drawer_chat_close"
       style="width: 500px !important;">
    <!--begin::Messenger-->
    <div class="card w-100 rounded-0" id="kt_drawer_chat_messenger">
      <!--begin::Card header-->
      <div class="card-header pe-5" id="kt_drawer_chat_messenger_header" style="min-height: auto;">

        <!--begin::Title-->
        <div v-if="room" class="card-title">
          <!--begin::User-->
          <div class="d-flex justify-content-center flex-column me-3">
            <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ room.title }}</a>
          </div>
          <!--end::User-->
        </div>
        <!--end::Title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar">
          <!--begin::Close-->
          <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_chat_close">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
            <span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
										<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
										<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
									</g>
								</svg>
							</span>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--end::Card toolbar-->
      </div>
      <!--end::Card header-->

      <!--begin::Card body-->
      <div class="card-body" id="kt_drawer_chat_messenger_body">
        <!--begin::Messages-->
        <div class="scroll-y me-n5 pe-5"
             data-kt-element="messages"
             data-kt-scroll="true"
             data-kt-scroll-activate="true"
             data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
             data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body"
             data-kt-scroll-offset="0px">
          <ContentBody v-model="room" scroll-id="kt_drawer_chat_messenger_body" />
        </div>
        <!--end::Messages-->
      </div>
      <!--end::Card body-->

      <!--begin::Card footer-->
      <ContentFooter v-model="room" id="kt_drawer_chat_messenger_footer"/>
      <!--end::Card footer-->

    </div>
    <!--end::Messenger-->
  </div>
  <!--end::Chat drawer-->
</template>

<script>
import {useStore} from "vuex";
import {computed} from "vue";
import ContentBody from "./content/ContentBody";
import ContentFooter from "./content/ContentFooter";

export default {
  name: "KTChatDrawer",
  components: {ContentFooter, ContentBody},
  setup() {
    const store = useStore()

    const room = computed(() => store.getters.currentRoom)

    return {
      room,
    }
  }
};
</script>
