<template>
  <div class="fv-row">

    <slot></slot>

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

    <slot name="checkbox"></slot>
    <slot name="help"></slot>

    <!--begin::Error-->
    <InputError :errors="errors" />
    <!--end::Error-->

  </div>
</template>

<script>
import {computed, reactive, ref, watch} from "vue";
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {ADD_ERROR} from "../../services/store/form.module";
import {useStore} from "vuex";
import InputError from "./InputError";

export default {
  components: {InputError},
  name: "InputText",
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

    return {
      v$,
      name,
      errors: computed(() => { return store.getters.errors(name.value) }),
      loading: computed(() => { return store.getters.loading }),
    };
  },
};
</script>
