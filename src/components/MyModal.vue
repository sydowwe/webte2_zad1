<template>
  <div class="modal" tabindex="-1" role="dialog" ref="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button
            type="button"
            class="close btn btn-close"
            data-dismiss="modal"
            aria-label="Close"
            @click="hideModal"
          >
          </button>
        </div>
        <div class="modal-body">
          <slot name="modal-body"></slot>
        </div>
        <div class="modal-footer">
          <slot name="modal-footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
    };
  },
  methods: {
    showModal() {
      $(this.$refs.modal).modal("show");
    },
    hideModal() {
      $(this.$refs.modal).modal("hide");
    },
  },
  watch: {
    title(newValue) {
      $(this.$refs.modal).find(".modal-title").text(newValue);
    },
  },
};
</script>
