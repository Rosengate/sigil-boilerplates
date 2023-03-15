<script>
import dialog from "@/utils/dialog.ts";

export default {
  methods: {
    alertTest() {
      dialog.alert('Hlelleoe');
    },
    confirmTest() {
      dialog.confirm('Sure?')
    }
  }
}
</script>
<template>
  <div>
    <a @click="alertTest" href="javascript:;">Alert</a>
  </div>
  <div>
    <a @click="confirmTest">Confirm</a>
  </div>
</template>