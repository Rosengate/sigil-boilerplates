<script setup>
const props = defineProps({
  modelValue: {
    required: true
  },
  min: Number,
  max: Number,
  step: Number
});

defineEmits(['update:modelValue'])
</script>
<template>
  <div>
    <input type="text" class="input" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
    <input class="slider is-fullwidth is-success" style="width: 100%;" :step="step" :min="min" :max="max" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" type="range">
  </div>
</template>