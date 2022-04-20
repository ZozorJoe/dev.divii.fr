<template>
  <!--begin::Card footer-->
  <div v-if="modelValue" class="card-footer pt-4">

    <!--begin::Input-->
    <textarea v-model="content" class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
    <!--end::Input-->
    <!--begin:Toolbar-->
    <div class="d-flex flex-stack">
      <!--begin::Actions-->
      <div class="d-flex align-items-center me-2">
        <button class="btn btn-file btn-sm btn-icon btn-active-light-primary me-1" type="button">
          <i class="bi bi-upload fs-3"></i>
          <input type="file" v-on:change="prepareUpload">
        </button>
      </div>
      <!--end::Actions-->
      <!--begin::Send-->
      <button @click="submit" class="btn btn-primary" type="button">Envoyer</button>
      <!--end::Send-->
    </div>
    <!--end::Toolbar-->

  </div>
  <!--end::Card footer-->
</template>

<script>
import {computed, ref, toRefs} from "vue";
import ApiService from "../../../services/api.service";

export default {
  name: 'ContentFooter',
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const content = ref(null)

    const { modelValue } = toRefs(props)

    const url = computed(() => {
      if(modelValue.value){
        return '/account/rooms/' + modelValue.value.id + '/messages';
      }
      return null;
    })

    const files = ref([])
    const submit = () => {
      if(!url) return;
      const data = new FormData();
      $.each(files.value, function(key, value){
        data.append('files[]', value);
      });
      data.append('content', content.value);
      ApiService.post(url.value, {content: content.value})
        .then((response) => {
          if(response.data.success){
            content.value = ''
          }
        })
    }

    const prepareUpload = function (event) {
      for (let i=0; i < event.target.files.length; i++){
        files.value.push(event.target.files[i]);
      }
    }

    return {
      files,
      content,
      submit,
      prepareUpload,
    }
  }
}
</script>
