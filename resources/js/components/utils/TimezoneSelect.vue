<template>
  <InputSelect
    v-if="models.length"
    v-model="model"
    :options="models"
    :placeholder="$t('messages.select.timezone')"
    :rules="{}"
    class="mb-0"
    name="timezone"
    field="label"
  />
</template>

<script>
import tzService from "../../services/tz.service";
import ApiService from "../../services/api.service";
import {onMounted, ref, watch, computed} from "vue";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";

export default {
  name: "TimezoneSelect",
  setup(props, { emit }){
    const store = useStore()
    const { t } = useI18n()

    const $timezone = computed(() => store.getters.timezone)
    const model = ref($timezone.value)

    const models = ref([])
    const loadModels = () => {
      ApiService.list('/timezones', null, t('timezone'), setModels, store, t)
    }
    const setModels = (value) => {
      models.value = value
    }
    onMounted(loadModels)

    watch(() => model.value, (value) => {
      tzService.setActiveTimezone(store, value)
      emit('input', value)
    })

    return {
      model,
      models,
    }
  },
}
</script>
