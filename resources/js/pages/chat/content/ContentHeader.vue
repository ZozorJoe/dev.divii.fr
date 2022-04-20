<template>
  <div v-if="modelValue" class="card-header">
    <!--begin::Title-->
    <div class="card-title">
      <!--begin::Users-->
      <div class="symbol-group symbol-hover">
        <template
          v-for="model in models"
          :key="model.id"
        >
          <BaseAvatar class="symbol-35px" :model-value="model" />
        </template>
      </div>
      <!--end::Users-->
    </div>
    <!--end::Title-->

    <!--begin::Card toolbar-->
    <div class="card-toolbar">
      <!--begin::Menu-->
      <router-link v-if="$filters.isAfter(modelValue.created_at)" :to="{name: 'account.video', params: {id: modelValue.id }}" class="btn btn-sm btn-primary">
        Visio
      </router-link>
      <!--end::Menu-->
    </div>
    <!--end::Card toolbar-->

  </div>
</template>

<script>
import {computed, ref, toRefs, watch} from "vue";
import ApiService from "../../../services/api.service";
import BaseAvatar from "../../../components/utils/BaseAvatar";

export default {
  name: 'ContentHeader',
  components: {BaseAvatar},
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const { modelValue } = toRefs(props)

    const models = ref([])

    const url = computed(() => {
      if(modelValue.value){
        return '/account/rooms/' + modelValue.value.id + '/users';
      }
      return null;
    })

    const loadModels = () => {
      if(!url.value) return;
      ApiService.get(url.value)
        .then((response) => {
          if(response.data.success){
            models.value = response.data.data
          }
        })
    }

    watch(() => url.value, () => { models.value = []; loadModels(); })

    return {
      models,
    }
  }
}
</script>
