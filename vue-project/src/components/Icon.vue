<script>
import {Icon} from "@iconify/vue";

export default {
  components: {Icon},
  props: {
    icon: {
      required: true
    }
  }
}
</script>
<template>
  <Icon :icon="icon" />
</template>