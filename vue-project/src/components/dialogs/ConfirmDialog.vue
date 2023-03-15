<script>
import {main} from "@/stores/main.ts";

export default {
  props: ['confirm'],
  methods: {
    close() {
      if (!this.confirm.skipResolveOnCancel) {
        this.confirm.resolve(false);
      }

      delete main().confirms[this.confirm.id];
    },
    next() {
      this.confirm.resolve(true);
      delete main().confirms[this.confirm.id];
    }
  }
}

</script>
<template>
  <div class="modal" style="z-index: 5; display: block;">
    <div class="modal-background" @click="close"></div>
    <div class="modal-card" style="margin-top: 100px;">
      <section class="modal-card-body">
        {{ confirm.message }}
      </section>
      <footer class="modal-card-foot">
        <button class="button button-cancel" @click="close">Cancel</button>
        <button class="button is-primary button-confirm" @click="next">Confirm</button>
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
  justify-content: space-between;
  .button-cancel {
    background: white;
    color: black;
    float: right;
  }
  .button-confirm {
    background: black;
  }
}
</style>