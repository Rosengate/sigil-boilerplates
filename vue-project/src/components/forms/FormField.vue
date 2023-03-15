<script setup>
import RequireAsterisk from "@/components/UIs/RequireAsterisk.vue";

const props = defineProps({
  label: {
    required: true
  },
  required: Boolean,
  iconTooltip: String
});
</script>

<template>
  <div class="field" style="position:relative;">
    <label class="label">{{ label }}
      <RequireAsterisk v-if="required" />

    </label>
    <div style="display: inline; position:absolute; top: 0px; right: 0px">
      <slot name="label-right"></slot>
    </div>
    <div class="control">
      <slot></slot>
    </div>
  </div>
</template>