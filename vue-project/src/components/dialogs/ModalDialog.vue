<script>
export default {
  props: ['title']
}
</script>
<template>
  <div class="modal" style="z-index: 1; display: block;">
    <div class="modal-background"></div>
    <div class="modal-card" style="margin-top: 100px;">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ title }}</p>
        <button class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <slot></slot>
      </section>
    </div>
  </div>
</template>