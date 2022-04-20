<template>
  <!--begin::Image input-->
  <div class="image-input image-input-outline" data-kt-image-input="true">
    <!--begin::Preview existing avatar-->
    <div class="image-input-wrapper w-125px h-125px" :style="background"></div>
    <!--end::Preview existing avatar-->
    <!--begin::Label-->
    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="Change avatar">
      <i class="bi bi-pencil-fill fs-7"></i>
      <!--begin::Inputs-->
      <input @change="upload" type="file" name="avatar" accept=".png, .jpg, .jpeg">
      <!--end::Inputs-->
    </label>
    <!--end::Label-->
    <!--begin::Cancel-->
    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancel avatar">
      <i class="bi bi-x fs-2"></i>
    </span>
    <!--end::Cancel-->
    <!--begin::Remove-->
    <span @click="deleteFile" v-if="modelValue" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove avatar">
      <i class="bi bi-x fs-2"></i>
    </span>
    <!--end::Remove-->
  </div>
  <!--end::Image input-->
</template>

<script>
import ApiService from "../../services/api.service";
import {onMounted, ref, watch} from "vue";

export default {
  name: "InputImage",
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(props, {emit}){
    const model = ref(props.modelValue)

    const background = ref(null)

    onMounted(() => {
      if(props.modelValue){
        background.value = 'background-image: url(' + props.modelValue.url + ')'
      }else{
        background.value = 'background-image: url(/img/image.svg)'
      }
    })

    watch(() => props.modelValue, (value) => {
      console.error(value)
      if(value) {
        background.value = 'background-image: url(' + value.url + ')'
      }else{
        background.value = 'background-image: url(/img/avatar.jpg)'
      }
    })

    const upload = (e) => {
      let formData = new FormData()
      formData.append('file', e.target.files[0])
      ApiService.post('/upload/avatar', formData)
        .then((response) => {
          if(response.data.success){
            emit('update:modelValue', response.data.data)
          }
        })
    }

    const deleteFile = (e) => {
      emit('update:modelValue', null)
    }

    return {
      model,
      background,
      upload,
      deleteFile,
    }
  }
};
</script>
