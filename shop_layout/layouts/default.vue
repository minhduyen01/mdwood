<template>
  <div class="wrapper">
      <Header></Header>
      <Nuxt />
      <Footer />
  </div>
</template>

<script>
export default {
  mounted() {
    this.$nextTick(() => {
      this.$nuxt.$loading.start()
      setTimeout(() => this.$nuxt.$loading.finish(), 500)
    })
  }
}
</script>

<style>
body {
  font-size: 13px;
}
@media (max-height: 890px) {
  .vm--modal{
    height: 680px !important;
    overflow: scroll !important;
  }
}
</style>
