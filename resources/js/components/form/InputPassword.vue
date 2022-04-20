<template>
  <div class="fv-row" :data-kt-password-meter="meter">

    <slot></slot>

    <!--begin::Input wrapper-->
    <div class="input-password position-relative" :class="{'mb-3': meter}">
      <!--begin::Input-->
      <input
        v-model="v$[name].$model"
        :disabled="loading"
        :class="{ 'is-invalid': v$[name].$dirty && errors.length, 'is-valid': v$[name].$dirty && !errors.length }"
        class="form-control form-control-lg form-control-solid"
        type="text"
        :name="name"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
      >
      <!--end::Input-->

      <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
          <i class="bi bi-eye-slash fs-2"></i>
          <i class="bi bi-eye fs-2 d-none"></i>
      </span>

    </div>
    <!--end::Input wrapper-->

    <!--begin::Meter-->
    <div class="d-flex align-items-center" data-kt-password-meter-control="highlight">
      <div v-if="meter" class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
      <div v-if="meter" class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
      <div v-if="meter" class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
      <div v-if="meter" class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
    </div>
    <!--end::Meter-->

    <!--begin::Error-->
    <InputError :errors="errors" />
    <!--end::Error-->

  </div>
</template>

<script>
import {computed, onMounted, reactive, ref, watch} from "vue";
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {ADD_ERROR} from "../../services/store/form.module";
import {useStore} from "vuex";
import InputError from "./InputError";

export default {
  name: 'InputPassword',
  components: {InputError},
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },
    name: {
      type: String,
      default: "input",
    },
    placeholder: {
      type: String,
      default: "",
    },
    rules: {
      type: Object,
      default: {required},
    },
    meter: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const store = useStore()

    const name = ref(props.name)

    const initialState = {}
    initialState[name.value] = props.modelValue

    const state = reactive(initialState)
    watch(() => props.modelValue, () => state[name.value] = props.modelValue)

    const rules = {}
    rules[name.value] = props.rules

    const v$ = useVuelidate(rules, state)

    watch(() => v$.value[name.value].$errors, (value) => {
      const errors = []
      value.forEach((item) => {
        errors.push(item.$message)
      })
      store.commit(ADD_ERROR, { name: name.value, errors })
    })

    onMounted(() => {
      KTPasswordMeter.createInstances();
    })

    return {
      v$,
      name,
      errors: computed(() => { return store.getters.errors(name.value) }),
      loading: computed(() => { return store.getters.loading }),
    };
  },
};
</script>
