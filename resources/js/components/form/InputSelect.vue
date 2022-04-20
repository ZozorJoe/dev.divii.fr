<template>
  <!--begin::Input-->
  <select
    ref="select"
    v-model="v$[name].$model"
    :class="{ 'is-invalid': v$[name].$dirty && errors.length, 'is-valid': v$[name].$dirty && !errors.length }"
    :data-placeholder="placeholder"
    class="form-select form-select-solid"
  >
    <option
      v-for="option in options"
      :key="option[id]"
      :selected="v$[name].$model == option[fieldValue] ? `selected` : ``"
      :value="option[fieldValue]"
    >
      {{ option[field] }}
    </option>
  </select>
  <!--end::Input-->
</template>

<script>
import {computed, onMounted, onUnmounted, reactive, ref, watch} from "vue";
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {ADD_ERROR} from "../../services/store/form.module";
import {useStore} from "vuex";
import InputError from "./InputError";

export default {
  components: {InputError},
  name: "InputSelect",
  props: {
    modelValue: {
      type: [Object, String, Number],
      default: null,
    },
    id: {
      type: String,
      default: null,
    },
    name: {
      type: String,
      default: "input",
    },
    field: {
      type: String,
      default: "title",
    },
    fieldValue: {
      type: String,
      default: "id",
    },
    placeholder: {
      type: String,
      default: "",
    },
    rules: {
      type: Object,
      default: {required},
    },
    options: {
      type: Array,
      default: [],
    },
  },
  setup(props, { emit }) {
    const store = useStore()

    const select = ref(null)

    const options = props.options

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

    onMounted(function(){
      $(select.value)
        // init select2
        .select2({ data: props.options })
        .val(props.modelValue)
        .trigger("change")
        // emit event on change.
        .on("change", function(event) {
          emit("update:modelValue", event.target.value);
        });
    })

    watch(() => props.modelValue, function(value) {
      // update value
      $(select.value)
        .val(value)
        .trigger("change");
    })

    watch(() => props.options, function(options) {
      // update options
      $(select.value)
        .empty()
        .select2({ data: options });
    })

    onUnmounted(() => {
      $(select.value)
        .off()
        .select2("destroy");
    })

    return {
      select,
      v$,
      name,
      options,
      errors: computed(() => { return store.getters.errors(name.value) }),
      loading: computed(() => { return store.getters.loading }),
    };
  },
};
</script>
