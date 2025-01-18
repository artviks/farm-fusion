<script setup lang="ts">
import {ref, onMounted} from 'vue';
import axiosInstance from './../../axios.ts';

// Reactive state for fields
const fields = ref([]);

// Fetch the list of fields
onMounted(() => {
  axiosInstance.get('fields').then((response) => {
    fields.value = response.data.member;
    console.log(response.data.member);
  });
});

</script>

<template>
  <div class="table-container">
    <table>
      <thead>
      <tr>
        <th>Name</th>
        <th>Size</th>
        <th>Notes</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="field in fields" :key="field.id">
        <td>{{ field.name }}</td>
        <td>{{ field.area }}</td>
        <td>{{ field.notes }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.table-container {
  margin: 20px;
  width: 100%;
  overflow-x: auto;
}
table {
  border-collapse: separate; /* Ensures border-radius works */
  border-spacing: 0; /* Prevents gaps between cells */
  border: 1px solid #ddd;
  border-radius: 8px; /* Rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow */
  overflow: hidden; /* Clips the corners for inner content */
  font-family: "Open Sans", sans-serif;
  text-align: left;
}

td {
  padding: 10px 15px;

}

th {
  padding: 20px 15px;
  background-color: #05472A;
  color: #F5F7F9;
  font-weight: normal;
}

tbody tr {
  color: #212121;
  font-size: 15px;
}

tbody tr:nth-child(even) {
  background-color: rgba(5, 71, 42, 0.10); /* Alternate row color */
}

tbody tr:hover {
  background-color: #DFFFE2; /* Highlight color on hover */
  cursor: pointer; /* Optional: Change cursor to indicate interactivity */
}

</style>