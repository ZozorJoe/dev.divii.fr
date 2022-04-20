<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.experts'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
              <slot name="title"></slot>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->

          <!--begin::Form-->
          <form @submit.prevent="submit" id="form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

              <!--begin::Input group-->
              <div class="row">
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label fw-bold fs-6">{{ $t('avatar') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12">
                      <InputImage v-model="avatar" />

                      <!--begin::Hint-->
                      <div class="form-text">{{ $t('allowed_image_types') }}</div>
                      <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label fw-bold fs-6">{{ $t('picto') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12">
                      <InputImage v-model="picto" />

                      <!--begin::Hint-->
                      <div class="form-text">{{ $t('allowed_image_types') }}</div>
                      <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label required fw-bold fs-6">{{ $t('background_color') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12 fv-row">
                      <BaseInput type="color" name="background_color" :placeholder="$t('messages.enter.background_color')" v-model="model.background_color" :rules="{}" />
                      <BaseError name="background_color"/>
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('full_name') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="mb-0 col-lg-6">
                      <BaseInput name="first_name" :placeholder="$t('messages.enter.first_name')" v-model="model.first_name" :rules="{}" />
                      <BaseError name="first_name" />
                    </div>
                    <div class="mb-0 col-lg-6">
                      <BaseInput name="last_name" :placeholder="$t('messages.enter.last_name')" v-model="model.last_name" :rules="{}" />
                      <BaseError name="last_name" />
                    </div>
                  </div>
                  <!--end::Row-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('birthday') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputDate
                    v-model="model.birthday"
                    :placeholder="$t('messages.select.date')"
                    class="w-100"
                    name="birthday"/>
                  <BaseError name="birthday"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('email') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputText name="email" class="mb-0" v-model="model.email" :rules="{}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('password') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputPassword name="password" class="mb-0" v-model="model.password" :rules="{}" :meter="true" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('password_confirmation') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputPassword name="password_confirmation" class="mb-0" v-model="model.password_confirmation" :rules="{}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">Position</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputText name="number" min="0" class="mb-0" v-model="model.order" :rules="{}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('disciplines') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
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
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <div>
                <!--begin::Separator-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Separator-->

                <!--begin::results-->
                <span class="fs-2x fw-bolder mb-10">{{ $t('description') }}</span>
                <!--end::results-->

                <!--begin::Input group-->
                <div class="row mb-6">
                  <!--begin::Label-->
                  <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('description') }}</label>
                  <!--end::Label-->
                  <!--begin::Col-->
                  <div class="col-xl-10 col-lg-8 fv-row">
                    <ckeditor v-if="editor.editor" :editor="editor.editor" v-model="model.description" :config="editor.editorConfig" />
                    <BaseError name="description"/>
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Input group-->
              </div>

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
              <router-link :to="{name: 'admin.experts'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
import ApiService from "../../../../services/api.service";
import {useStore} from "vuex";
import {computed, onMounted, ref, watch} from "vue";
import useVuelidate from "@vuelidate/core";
import {useRoute} from "vue-router";
import {useI18n} from "vue-i18n";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {SET_ERROR, SET_SUCCESS} from "../../../../services/store/form.module";

export default {
  name: 'ExpertForm',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    const avatar = ref(null)
    const picto = ref(null)

    const getData = () => {
      const data = model.value;

      if(avatar.value){
        data.avatar_id = avatar.value.id
      }else{
        data.avatar_id = null
      }

      if(picto.value){
        data.picto_id = picto.value.id
      }else{
        data.picto_id = null
      }

      if(slots.value){
        data.time_slots = slots.value
      }

      if($timezone.value){
        data.timezone = $timezone.value
      }

      return data;
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const create = () => {
      const data = getData()
      ApiService.store('/admin/experts', data, t('expert'), initModel, store, t)
        .then((response) => {
          if(response.data.success) {
            toastr.success("Votre demande a été bien sauvegardée.")
          }else{
            toastr.error("La demande n'a pas été bien sauvegardée.")
          }
        })
    }

    const update = () => {
      const data = getData()
      ApiService.update('/admin/experts/' + id.value, data, t('expert'), initModel, store, t)
        .then((response) => {
          if(response.data.success) {
            toastr.success("La modification a été bien sauvegardée.")
          }else{
            toastr.error("La modification n'a pas été bien sauvegardée.")
          }
        })
    }

    const loadModel = (value) => {
      if(!value){ return; }
      const params = {params:{with:'disciplines,timeSlots,avatar,picto', 'timezone': $timezone.value}}
      ApiService.show('/admin/experts/' + value, params, t('expert'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        slots.value = [
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [["08:00", "12:00"], ["14:00", "17:00"]],
          [],
          []
        ];
        return;
      }

      let newValue = {}
      newValue.is_active = value.is_active
      newValue.order = value.order
      newValue.first_name = value.first_name
      newValue.last_name = value.last_name
      newValue.birthday = value.birthday
      newValue.email = value.email
      newValue.description = value.description
      newValue.background_color = value.background_color

      avatar.value = value.avatar ? value.avatar : null
      picto.value = value.picto ? value.picto : null

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

      slots.value = []
      if(value.time_slots){
        value.time_slots.forEach(item => {
          slots.value.push(item)
        })
      }
    }

    const id = ref(route.params.id)
    const initialModel = {
      is_active: true,
      order: 0,
      first_name: '',
      last_name: '',
      birthday: '',
      email: '',
      description: '',
      background_color: '',
      disciplines: [],
      durations: [],
      preparations: [],
    }
    const model = ref(null)
    const init = () => {
      if(id.value){
        loadModel(id.value)
      }else{
        initModel()
      }
    }
    watch(() => id.value, () => { init() })
    onMounted(init)

    const disciplines = ref([])
    const loadDisciplines = () => {
      ApiService.list('/admin/disciplines', {params:{'per-page':-1}}, t('discipline'), setDisciplines, store, t)
    }
    const setDisciplines = (value) => {
      disciplines.value = value
    }
    onMounted(loadDisciplines)

    const durations = ref([])
    const loadDurations = () => {
      durations.value = []
      ApiService.get('/admin/durations', null)
        .then(({data}) => {
          if(data.success) {
            durations.value = data.data
          }
        })
    }
    onMounted(loadDurations)

    const initialSlot = {
      id: null,
      start_at: null,
      end_at: null,
    }
    const slots = ref([])
    const addTimeSlot = function (index) {
      slots.value[index].push(Object.assign({}, initialSlot))
    }
    const removeTimeSlot = function (index, index1) {
      if (index > -1 && index1 > -1) {
        slots.value[index].splice(index1, 1)
      }
    }

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

    return {
      v$,
      avatar,
      picto,
      model,
      disciplines,
      durations,
      slots,
      submit,
      addTimeSlot,
      removeTimeSlot,
      checkDiscipline,
      editor:{
        editor: ClassicEditor,
        editorConfig: {
          // The configuration of the editor.
        }
      }
    }
  }
}
</script>
