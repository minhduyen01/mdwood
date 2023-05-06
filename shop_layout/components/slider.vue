<template>
    <b-carousel
        controls
        img-width="1859"
        img-height="800"
        :interval="3000"
    >
        <b-carousel-slide v-for="item in slide" :key="item.id"
          :img-src="`http://127.0.0.1:8000/storage/uploads/${item.image}`"
          :caption="item.name"
          :text-html="item.description"
        ></b-carousel-slide>
    </b-carousel>
</template>
<script>
export default {
  data() {
    return{
      slide: []
    }
  },
  created() {
    this.$axios.get('/slide').then(res => {
      this.slide = res.data
    })
  }
}
</script>

<style lang="scss">
.carousel-inner{
  height: 550px !important;
}
</style>
