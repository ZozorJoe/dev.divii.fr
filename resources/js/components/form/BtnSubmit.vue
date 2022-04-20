<template>
  <button type="submit" :disabled="loading" class="left-btn fiche-btn btn with-zindex rounded-pill bg-yellow btn-icon-dark mb-n10 text-uppercase" :data-kt-indicator="loading ? `on` : `off`">
    <span class="indicator-label">{{ $t('submit') }}</span>
    <span class="indicator-progress">{{ $t('messages.please.wait') }}
      <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
  </button>
</template>

<script>
import {useStore} from "vuex";
import {computed} from "vue";

export default {
  name: "BtnSubmit",
  setup() {
    const store = useStore()

    return {
      loading: computed(() => { return store.getters.isLoading }),
    };
  },
};
</script>
