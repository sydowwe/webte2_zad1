<template>
  <div>
    <h1>Sportsman Placements</h1>
    <button @click="addNew">Add New</button>
    <table id="sportsmanTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Placement</th>
          <th>Edit</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sportsman in sportsmen">
          <td>{{ sportsman.name }}</td>
          <td>{{ sportsman.placement }}</td>
          <td><button @click="edit(sportsman)">Edit</button></td>
          <td><button @click="remove(sportsman)">Remove</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    person_id: {
      type: Number,
      default: null,
    }
  },
  data() {
    return {
      placements: [{
        placement: 0,
        games: '',          
        discipline: '',
      }],
    };
  },
  created() {    
    $.ajax({
          type: "GET",
          contentType: "application/json",
          url: `/getPlacements.php?person_id=${this.person_id}`
        }).done(placement => {
          this.placements.placement = placement.placement;
          this.placements.games = placement.games;
          this.placements.discipline = placement.discipline;
        });

    $(() => {
      $("#sportsmanTable").DataTable();
    });
  },
  methods: {
    addNew() {
     
    },
    edit(sportsman) {},
    remove(sportsman) {
      // Remove the sportsman from the database using PHP with MySQLi
      // Remove the sportsman from the sportsmen array using
      // this.sportsmen.splice(index, 1)
    },
  },
};
</script>

<style>
/* Your custom styles */
</style>
