<template>
  <!--begin::Avatar-->
  <div v-if="modelValue" class="symbol symbol-circle symbol-20px">
    <img v-if="modelValue.avatar_id" alt="Pic" :src="`/u/image-${modelValue.id}.jpg`" />
    <div v-else-if="modelValue.name" class="symbol-label fs-6 fw-bold text-success">{{ modelValue.name.charAt(0).toUpperCase() }}</div>
  </div>
  <!--end::Avatar-->
</template>

<script>
export default {
  name: "BaseAvatar",
  props: {
    modelValue: {
      type: Object,
      default: null,
    },
  },
};
</script>
