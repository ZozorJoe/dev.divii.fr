<template>
  <!--begin::Error-->
  <InputError :errors="errors" />
  <!--end::Error-->
</template>

<script>
import {computed, ref} from "vue";
import {useStore} from "vuex";
import InputError from "./InputError";

export default {
  components: {InputError},
  name: "BaseError",
  props: {
    name: {
      type: String,
      default: "input",
    },
  },
  setup(props) {
    const store = useStore()

    const name = ref(props.name)

    return {
      errors: computed(() => { return store.getters.errors(name.value) }),
    };
  },
};
</script>
