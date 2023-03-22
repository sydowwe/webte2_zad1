<template>
  <div class="container">
    <h4 class="text-center mb-2">Zadajte QR kód z authentificator aplikácie</h4>
    <form @submit.prevent="handleSubmit" class="d-flex flex-column">
      <div class="form-group mb-2">
        <label class="form-label" for="code">QR kód</label>
        <input
          type="text"
          id="code"
          class="form-control form-control-lg"
          v-model="code"
        />
      </div>
    </form>
  </div>
</template>
<script>
import MyModal from "../components/MyModal.vue";
export default {
  components: {
    MyModal,
  },
  props: {
    personData: {
      type: Object,
      required: true,
    },    
  },
  data() {
    return {
      code: "",
    };
  },
  created() {},
  methods: {
    handleSubmit() {
      this.personData.code = this.code;
      console.log(this.personData);
    //   $.ajax({
    //     type: "POST",
    //     contentType: "application/json",
    //     url: "/api/verifyQR.php",
    //     data: JSON.stringify(this.personData),
    //     dataType: "json",
    //   })
    //     .done((data) => {
    //       this.isError = data.error;
    //       if (!this.isError) {  
    //           this.$router.push({ name: "home"});      
    //       } else {
    //         this.errorMessage = data.body;
    //         this.$refs.myModal.showModal();
    //       }
    //     })
    //     .fail((error) => {
    //       console.log(error);
    //     });
    },
  },
};
</script>