<template>
  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label">{{ label }}</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control">
          <inputValidate class="input" :type="tipe" :placeholder="placeholder" :iconLeft="iconLeft" :iconRight="iconRight" :error="error" />
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'base-input-label',
  components: {
    inputValidate: () => import(/* webpackChunkName: "input" */ './InputValidate')
  },

  props: {
    label: {
      type: String,
      default: 'label'
    },
    iconLeft: {
      type: String,
      default: ''
    },
    iconRight: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: 'input'
    },
    tipe: {
      type: String,
      default: 'input'
    }
  }
};
</script>

<style></style>
