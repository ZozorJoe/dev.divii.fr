<template>
  <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
    <!--begin::Messenger-->
    <div class="card h-100" id="kt_chat_messenger">

      <!--begin::Card header-->
      <ContentHeader v-model="modelValue" id="kt_chat_messenger_header" />
      <!--end::Card header-->

      <!--begin::Card body-->
      <div class="card-body" id="kt_chat_messenger_body">
        <!--begin::Messages-->
        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto"
             id="kt_chat_messenger_messages"
             data-kt-element="messages"
             data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}"
             data-kt-scroll-max-height="auto"
             data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
             data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body"
             data-kt-scroll-offset="-2px">

          <ContentBody v-model="modelValue" scroll-id="kt_chat_messenger_body" />

        </div>
        <!--end::Messages-->

      </div>
      <!--end::Card body-->

      <!--begin::Card footer-->
      <ContentFooter v-model="modelValue" id="kt_chat_messenger_footer" />
      <!--end::Card footer-->
    </div>
    <!--end::Messenger-->

  </div>
</template>

<script>
import {ref, watch} from "vue";
import ContentHeader from "./content/ContentHeader";
import ContentFooter from "./content/ContentFooter";
import ContentBody from "./content/ContentBody";

export default {
  name: 'Content',
  components: {ContentBody, ContentFooter, ContentHeader},
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(props){
    const modelValue = ref(null)

    watch(() => props.modelValue, () => {
      modelValue.value = props.modelValue
    })

    return {
      modelValue
    }
  }
}
</script>
