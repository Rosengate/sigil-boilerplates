<script>
import {loader} from "@/stores/loader";
import AlertDialog from "@/components/dialogs/AlertDialog.vue";
import {main} from "@/stores/main.ts";
import ConfirmDialog from "@/components/dialogs/ConfirmDialog.vue";

export default {
  components: {ConfirmDialog, AlertDialog},
  data() {
    return {
      loader: loader(),
      alerts: main().alerts,
      confirms: main().confirms
    }
  }
}
</script>

<template>
  <AlertDialog v-for="alert in alerts" :alert="alert" />
  <ConfirmDialog v-for="confirm in confirms" :confirm="confirm" />
</template>