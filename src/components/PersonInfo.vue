<template>

  <div class="container my-4">
    <div class="row">
      <div class="col-md-10 col-12 mx-auto">
        <h2 class="text-center">{{ viewData.name }} {{ viewData.surname }}</h2>
        <hr>
        <div class="row">
          <div class="col-md-6 col-12">
            <p><strong>Dátum narodenia:</strong> {{ viewData.birthDay }}</p>
            <p><strong>Miesto narodenia:</strong> {{ viewData.birthPlace }}</p>
            <p><strong>Krajina narodenia:</strong> {{ viewData.birthCountry }}</p>
          </div>
          <div class="col-md-6 col-12">
            <p><strong>Dátum úmrtia:</strong> {{ viewData.deathDay }}</p>
            <p><strong>Miesto úmrtia:</strong> {{ viewData.deathPlace }}</p>
            <p><strong>Krajina úmrtia:</strong> {{ viewData.deathCountry }}</p>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <hr>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      viewData: {
        name: "",
        surname: "",
        birthDay: "",
        birthPlace: "",
        birthCountry: "",
        deathDay: "",
        deathPlace: "",
        deathCountry: "",
      },
    };
  },
  created() {
    $.ajax({
      type: "GET",
      contentType: "application/json",
      url: `/api/getPerson.php?id=${this.id}`,
      dataType: "json",
    }).done((data) => {
      console.log(data);
      this.viewData.name = data.name;
      this.viewData.surname = data.surname;
      this.viewData.birthDay = data.birth_day;
      this.viewData.birthPlace = data.birth_place;
      this.viewData.birthCountry = data.birth_country;
      this.viewData.deathDay = data.death_day;
      this.viewData.deathPlace = data.death_place;
      this.viewData.deathCountry = data.death_country;
    });
  },
};
</script>
<style scoped>
hr {
  border-top: 3px solid #333333;
}
div{
  font-size: 1.3rem;
}
p{
  padding-left: 10px;
  border: 3px ridge #1d1873;
  border-radius: 10px;
}
</style>