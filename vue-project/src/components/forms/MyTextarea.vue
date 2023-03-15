<script setup>
import {ref} from "vue";

const props = defineProps(['helo']);


</script>
<template>
  <div @click="increase">
    {{ test }}
  </div>
</template>