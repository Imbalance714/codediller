<template>
    <v-expand-transition>
        <v-list v-if="model" class="red lighten-3">
            <v-list-tile
                    v-for="(field, i) in fields"
                    :key="i"
            >
                <v-list-tile-content>
                    <v-list-tile-title v-text="field.value"></v-list-tile-title>
                    <v-list-tile-sub-title v-text="field.key"></v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-expand-transition>
</template>

<script>
  export default {
    props: 'Customer',
    data () {
      return {
        customers: [{
          name: null,
          phone: null,
        }]
      }
    },
    created() {
      this.axios.get('http://test/customers?name=Roy').then((response) => {
        console.log(response.data)
      })
    }
  }
</script>
