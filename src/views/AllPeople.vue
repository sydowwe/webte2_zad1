<template>
    <h1>Pridať športovca</h1>
    <div class="">
        <person-table></person-table>
    </div>
  </template>
  <script>
    import PersonTable from '../components/PersonTable.vue';
    export default {
        components: {
            PersonTable
        }
    }
  </script>