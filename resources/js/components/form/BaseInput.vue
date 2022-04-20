<template>
  <!--begin::Input-->
  <input
    v-model="v$[name].$model"
    :disabled="loading"
    :class="{ 'is-invalid': v$[name].$dirty && errors.length }"
    class="form-control form-control-lg form-control-solid mb-0"
    :type="type"
    :name="name"
    :placeholder="placeholder"
    @input="$emit('update:modelValue', $event.target.value)"
  >
  <!--end::Input-->
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
  name: "BaseInput",
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
      store.commit(ADD_ERROR, { name: name.value, errors })
    })

    return {
      v$,
      name,
      type,
      errors: computed(() => { return store.getters.errors(name.value) }),
      loading: computed(() => { return store.getters.loading }),
    };
  },
};
</script>
