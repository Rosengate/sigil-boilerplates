<script>
import {main} from "@/stores/main.ts";

export default {
  props: ['alert'],
  methods: {
    close() {
      delete main().alerts[this.alert.id];
    }
  }
}
</script>
<template>
  <div class="modal" style="z-index: 5; display: block;">
    <div class="modal-background" @click="close"></div>
    <div class="modal-card" style="margin-top: 100px;">
      <section class="modal-card-body">
        {{ alert.message }}
      </section>
      <footer class="modal-card-foot" style="justify-content: flex-end;">
        <button class="button is-danger is-pulled-right" @click="close">Close</button>
      </footer>
    </div>
  </div>
</template>
<style scoped lang="scss">
.modal-card-foot {
  background: white;
}

.modal-card {
  border-radius: 5px;
}

footer {
  .button {
    background: black;
  }
}
</style>
