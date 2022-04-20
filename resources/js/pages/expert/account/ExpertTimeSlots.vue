<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

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
              <h3 class="fw-bolder m-0">Mes disponibilités</h3>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->

          <!--begin::Form-->
          <form @submit.prevent="submit" id="form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

              <div
                v-if="slots.length">
                <!--begin::Separator-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Separator-->

                <!--begin::results-->
                <span class="fs-2x fw-bolder mb-10">{{ $t('availabilities') }}</span>
                <!--end::results-->

                <!--begin::Input group-->
                <div
                  class="row mb-6"
                  v-for="(items, index) in slots"
                  :key="`slot-items-${index}`"
                >
                  <!--begin::Label-->
                  <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $filters.formatDayOfWeek(index) }}</label>
                  <!--end::Label-->
                  <!--begin::Col-->
                  <div class="col-xl-10 col-lg-8">
                    <div class="fv-row"
                         v-for="(item, index1) in items"
                         :key="`slot-items-${index}-item-${index1}`"
                    >
                      <div class="col-lg-12 col-xxl-9">
                        <div class="kt-margin-b-10">
                          <div class="form-group row">
                            <div class="col-lg-4">
                              <!--begin::Input-->
                              <InputTime
                                :name="`slots.${index}.${index1}.start_at`"
                                :placeholder="$t('messages.select.hour')"
                                v-model="item[0]" />
                              <BaseError :name="`slots.${index}.${index1}.start_at`"/>
                              <!--end::Input-->
                            </div>
                            <div class="col-lg-4">
                              <!--begin::Input-->
                              <InputTime
                                :name="`slots.${index}.${index1}.end_at`"
                                :placeholder="$t('messages.select.hour')"
                                v-model="item[1]" />
                              <BaseError :name="`slots.${index}.${index1}.end_at`"/>
                              <!--end::Input-->
                            </div>
                            <div class="col-lg-4">
                              <button type="button" @click="removeTimeSlot(index, index1)" class="btn btn-danger">
                                {{ $t('delete') }}
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fv-row">
                      <button type="button" @click="addTimeSlot(index)" class="btn btn-primary">{{ $t('add') }}</button>
                    </div>

                    <!--begin::Separator-->
                    <div class="separator separator-solid my-6"></div>
                    <!--end::Separator-->
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Input group-->
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
  name: 'ExpertTimeSlots',
  setup(){
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'time_slots'},
      ])
    })

    const slots = ref([])
    const initialSlot = {
      id: null,
      start_at: null,
      end_at: null,
    }
    const addTimeSlot = function (index) {
      slots.value[index].push(Object.assign({}, initialSlot))
    }
    const removeTimeSlot = function (index, index1) {
      if (index > -1 && index1 > -1) {
        slots.value[index].splice(index1, 1)
      }
    }

    const initModel = (value) => {
      if(!value){
        slots.value = [
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [],
          []
        ];
      }else{
        slots.value = []
        value.forEach(item => {
          slots.value.push(item)
        })
      }
    }
    const loadModel = () => {
      const params = {params:{'timezone': $timezone.value}}
      ApiService.show('/expert/account/time-slots', params, t('time_slot'), initModel, store, t)
    }
    onMounted(loadModel)

    const getData = () => {
      const data = {time_slots: slots.value};
      if($timezone.value){
        data.timezone = $timezone.value
      }
      return data;
    }
    const submit = () => {
      const data = getData();
      ApiService.update('/expert/account/time-slots', data, t('time_slot'), initModel, store, t)
    }

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModel() })

    return {
      slots,
      submit,
      addTimeSlot,
      removeTimeSlot,
    }
  }
}
</script>
