<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('save') }}</button>
      <!--end::Buttons-->
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <div class="card mb-5 mb-xl-10">
          <!--begin::Card header-->
          <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
              <h3 class="fw-bolder m-0">Mes disciplines</h3>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->

          <!--begin::Form-->
          <form @submit.prevent="submit" id="form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
              <div
                v-for="discipline in disciplines"
                :key="`checkbox-discipline-item-${discipline.id}`"
                class="row mb-7">
                <div class="col-3">
                  <label
                    class="form-check form-check-custom form-check-solid form-check-inline mb-2">
                    <input @change="checkDiscipline(discipline)" class="form-check-input" v-model="model.disciplines" type="checkbox" name="disciplines[]" :value="discipline.id">
                    <span class="form-check-label fw-bold text-gray-700 fs-6">{{  discipline.name }}</span>
                  </label>
                </div>
                <div class="col-3">
                  <div v-if="model.durations[discipline.id]" class="checkbox-list">
                    <label
                      v-for="duration in durations"
                      :key="`checkbox-duration-item-${discipline.id}-${duration.id}`"
                      class="form-check form-check-custom form-check-solid form-check-inline mb-2">
                      <input class="form-check-input" v-model="model.durations[discipline.id]" type="checkbox" :name="`durations[${discipline.id}][]`" :value="duration.id">
                      <span class="form-check-label fw-bold text-gray-700 fs-6">{{  duration.label }}</span>
                    </label>
                  </div>
                </div>
                <div v-if="model.preparations[discipline.id] !== undefined" class="col-6">
                  <label
                    class="form-check form-check-custom form-check-solid form-check-inline mb-2">
                    <input class="form-check-input" v-model="model.preparations[discipline.id]" type="checkbox" name="preparations[]">
                    <span class="form-check-label fw-bold text-gray-700 fs-6">Temps minimum de préparation [24h]</span>
                  </label>
                </div>
              </div>

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('save') }}</button>
            </div>
            <!--end::Actions-->

          </form>
          <!--end::Form-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {computed, onMounted, ref, watch} from "vue";
import ApiService from "../../../services/api.service";
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";

export default {
  name: 'ExpertDisciplines',
  setup(){
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'disciplines'},
      ])
    })

    const model = ref(null)
    const loadModel = () => {
      const params = {params:{with:'disciplines'}}
      ApiService.show('/expert/account', params, t('expert'), initModel, store, t)
    }
    const initModel = (value) => {
      let newValue = {}
      newValue.durations = {}
      newValue.preparations = {}

      newValue.disciplines = []
      if(value.disciplines){
        value.disciplines.forEach(item => {
          newValue.disciplines.push(item.id)
          newValue.durations[item.id] = item.durations
          newValue.preparations[item.id] = item.with_preparation
        })
      }
      model.value = Object.assign({}, newValue);
    }
    onMounted(loadModel)

    const durations = ref([])
    const loadDurations = () => {
      durations.value = []
      ApiService.get('/expert/durations', null)
        .then(({data}) => {
          if(data.success) {
            durations.value = data.data
          }
        })
    }
    onMounted(loadDurations)

    const disciplines = ref([])
    const loadDisciplines = () => {
      ApiService.list('/expert/disciplines', {params:{'per-page':-1}}, t('discipline'), setDisciplines, store, t)
    }
    const setDisciplines = (value) => {
      disciplines.value = value
    }
    onMounted(loadDisciplines)

    const checkDiscipline = function (value) {
      const checked = model.value.disciplines.find((item) => item === value.id)
      if(checked){
        model.value.durations[value.id] = []
        model.value.preparations[value.id] = false
      }else{
        model.value.durations[value.id] = undefined
        model.value.preparations[value.id] = undefined
      }
    }

    const submit = () => {
      const data = model.value
      ApiService.update('/expert/account/disciplines', data, t('expert'), initModel, store, t)
    }

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModel() })

    return {
      model,
      durations,
      disciplines,
      submit,
      checkDiscipline,
    }
  }
}
</script>
