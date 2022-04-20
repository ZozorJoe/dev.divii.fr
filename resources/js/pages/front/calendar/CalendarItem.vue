<template>
  <div class="card card-bordered bg-transparent mb-5 mb-xl-8 calendar-block-wrapper container-fluid">
    <!--begin::Body-->
    <div class="card-body d-flex flex-column p-0">
      <!--begin::Stats-->
      <div class="flex-grow-1 card-p pb-0">
        <div class="d-flex flex-stack flex-wrap">
          <div class="me-2">
            <a href="#" class="text-white text-hover-primary fw-bolder text-capitalize fs-3">{{ title }}</a>
          </div>
        </div>
      </div>
      <!--end::Stats-->

      <!--begin::Row-->
      <div v-if="loading" class="row">
        <div class="text-center my-10">
          <span class="spinner-border text-white"></span>
        </div>
      </div>
      <!--end::Row-->

      <!--begin::Row-->
      <div v-if="models.length" class="calendar-block border-bottom">
        <div
          v-for="day in models[0]"
          class="calendar-item-wrapper text-white text-center day-blocks">
          {{ $filters.formatWeekDay(day.date) }}
        </div>
      </div>
      <!--begin::Row-->

      <!--begin::Row-->
      <div
        v-for="(weekDays, index1) in models"
        class="calendar-block">
        <div
          v-for="(day, index2) in weekDays"
          :class="{'border-end': index2 < weekDays.length - 1, 'border-bottom': index1 < models.length - 1}"
          class="flex-1 text-end p-2 h-250px h-xl-300px h-xxl-350px calendar-item-wrapper">
          <span v-if="!day.formations.length" class="text-white p-2">{{ $filters.formatDayTz(day.date) }}</span>
          <FormationItem
            v-else
            class="overflow-hidden formation-item-hover calendar-item"
            :formation="day.formations[0]"
          />
        </div>
      </div>
      <!--begin::Row-->

    </div>
    <!--end::Body-->
  </div>
</template>

<script>
import {ref, onMounted, computed, watch} from "vue";
import ApiService from "../../../services/api.service";
import FormationItem from "./FormationItem";

export default {
  name: 'CalendarItem',
  props:['title', 'start', 'end'],
  components: {FormationItem},
  setup(props){
    const start = ref(props.start);
    const end = ref(props.end);

    const models = ref([])
    const page = ref(1)
    const per_page = ref(2)
    const meta = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value}
      if(per_page.value){
        data['per-page'] = per_page.value
      }
      if(start.value){
        data['start'] = start.value.toDate().toISOString()
      }
      if(end.value){
        data['end'] = end.value.toDate().toISOString()
      }
      return data
    })

    const changePerPage = (value) => {
      per_page.value = value
    }

    const loadModels = () => {
      loading.value = true
      ApiService.get('/calendar/formations', {params: params.value})
        .then(({data}) => {
          if(data.success) {
            models.value = data.data
            meta.value = data.meta
          }
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(loadModels)

    watch(() => params.value, () => { loadModels() })

    return {
      models,
      page,
      meta,
      loading,
      loadModels,
      changePerPage,
    }
  }
}
</script>
