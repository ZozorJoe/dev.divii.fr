<template>
  <!--begin::Input-->
  <input
    ref="element"
    v-model="v$[name].$model"
    :disabled="loading"
    :class="{ 'is-invalid': v$[name].$dirty && errors.length, 'is-valid': v$[name].$dirty && !errors.length }"
    class="form-control form-control-lg form-control-solid"
    :type="type"
    :id="id"
    :name="name"
    :placeholder="placeholder"
    readonly="readonly"
    @input="$emit('update:modelValue', $event.target.value)"
  >
  <!--end::Input-->
</template>

<script>
import {computed, onMounted, reactive, ref, watch} from "vue";
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {ADD_ERROR} from "../../services/store/form.module";
import {useStore} from "vuex";
import InputError from "./InputError";

export default {
  components: {InputError},
  name: "InputDate",
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },
    type: {
      type: String,
      default: "text",
    },
    name: {
      type: String,
      default: "input",
    },
    id: {
      type: String,
      default: "",
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

    const type = ref(props.type)

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

    const element = ref(null)

    onMounted(() => {
      $(element.value).flatpickr()
    })

    return {
      v$,
      element,
      name,
      type,
      errors: computed(() => { return store.getters.errors(name.value) }),
      loading: computed(() => { return store.getters.loading }),
    };
  },
};
</script>
