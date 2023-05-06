<template>
  <div class="el-input">
    <b-form-select
      :value="value"
      :options="options"
      @input="setSelected"
      class="el-input__inner"
    >
      <template #first>
        <b-form-select-option v-if="placeholder" :value="null" disabled>{{
          placeholder
        }}</b-form-select-option>
      </template>
    </b-form-select>
  </div>
</template>

<script>
export default {
  name: "FormSelect",
  props: {
    options: Array,
    value: [String, Number, Object],
    selectType: {
      type: String,
      default: "id"
    },
    placeholder: {
      type: String
    },
  },
  methods: {
    setSelected(val) {
      this.$emit("input", val);
    }
  }
};
</script>
<style lang="scss">
select option {
  background: white;
  color: black;
  font-size: 16px;
}
</style>
