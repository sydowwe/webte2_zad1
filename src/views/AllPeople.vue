<template>
    <h1>Všetci naši olympionici</h1>
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