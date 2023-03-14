<template>
  
</template>
<script>
export default {
  props: {
    name: {
      type: String,
      default: '',
    },

  },
  data() {
    return {
     
    };
  },
  created() {
    const myModal = new bootstrap.Modal(document.getElementById(this.name), options)
  },
};
</script>
