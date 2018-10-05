<template>
    <v-app light>
        <v-content>
            <v-container fluid justify-center align-center d-flex>
                <v-flex xs6>
                    <v-card
                            color="grey lighten-3"
                            light
                    >
                        <v-card-title class="headline  lighten-4 black--text">
                            Please fill out the form
                        </v-card-title>
                        <v-expand-transition>
                            <v-list v-if="model" class="white">
                                <template v-for="(customer, index) in customers">
                                    <v-list-tile
                                            :key="index"
                                            py-2
                                    >
                                        <v-list-tile-action>
                                            <v-icon color="indigo">assignment_ind</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{customer.name}}
                                                <v-tooltip right v-if="index === 0">
                                                    <v-icon color="yellow darken-2" slot="activator">star</v-icon>
                                                    <span>Group leader</span>
                                                </v-tooltip>
                                            </v-list-tile-title>
                                            <v-list-tile-sub-title>{{ customer.phone | phone }}</v-list-tile-sub-title>
                                        </v-list-tile-content>
                                        <v-list-tile-action>
                                            <v-btn icon ripple @click="deleteCustomer(index)"
                                                   :disabled="index === 0 && customers.length > 1">
                                                <v-icon color="red">delete</v-icon>
                                            </v-btn>
                                        </v-list-tile-action>
                                    </v-list-tile>
                                    <v-divider></v-divider>
                                </template>
                            </v-list>
                        </v-expand-transition>
                        <v-card-text>
                            <!-- <label>
                                 <input type="text" v-model="name" @input="" placeholder="Search for names..">
                             </label>-->

                            <!--<ul id="myUL">
                                <li><a href="#">Adele</a></li>
                                <li><a href="#">Agnes</a></li>

                                <li><a href="#">Billy</a></li>
                                <li><a href="#">Bob</a></li>

                                <li><a href="#">Calvin</a></li>
                                <li><a href="#">Christina</a></li>
                                <li><a href="#">Cindy</a></li>
                            </ul>-->

                            <v-autocomplete
                                    v-model="model"
                                    :items="items"
                                    :loading="isLoading"
                                    :search-input.sync="search"
                                    hide-no-data
                                    color="blue"
                                    label="Set shopify customer name"
                                    item-text="name"
                                    item-value="name"
                                    clearable
                                    editable
                                    placeholder="Start typing to Search"
                                    :rules="[rules.required]"
                                    return-object
                            ></v-autocomplete>
                            <v-form v-model="isValid" ref="visitorForm">
                                <v-text-field v-model="phone" mask="phone" :return-masked-value="false" label="Phone" :rules="[rules.required]"></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-flex d-flex>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                        :disabled="!model || !model.name"
                                        color="green lighten-1"
                                        @click="addSelectedToCustomerArray()"
                                >
                                    Add Now
                                    <v-icon right>mdi-close-circle</v-icon>
                                </v-btn>
                                <v-btn
                                        :disabled="!customers.length"
                                        color="light-blue darken-1"
                                        @click="addVisitors"
                                >
                                    To Conference
                                    <v-icon right>mdi-close-circle</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </v-flex>
                        <v-snackbar
                                v-model="snackbar"
                                right
                                top
                                :timeout="timeout"
                        >
                            {{ snackbarText }}
                            <v-btn
                                    color="pink"
                                    flat
                                    @click="snackbar = false"
                            >
                                Close
                            </v-btn>
                        </v-snackbar>
                    </v-card>
                </v-flex>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
  import axios from 'axios'

  Vue.filter('phone', (phone) => {
    if (!phone) return '—';
    return phone.replace(/[^0-9]/g, '')
      .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
  });

  export default {
    data: () => ({
      rules: {
        required: value => !!value || 'Required.'
      },
      isValid: true,
      snackbar: false,
      timeout: 6000,
      snackbarText: null,
      text: '',
      descriptionLimit: 60,
      customers: [],
      isLoading: false,
      name: '',
      model: {
        name: null,
        phone: '',
      },
      search: null,
      searchCopy: null,
      phone: null,
      items: [],
    }),
    computed: {},
    watch: {
      name: _.debounce(function (val) {
        window.axios.get('http://test/customers?name=' + val)
          .then((res) => {
            if (res.data.success) {
              this.items = res.data.data;
            }
          })
          .catch(err => {
            console.log(err)
          })
          .finally(() => (this.isLoading = false))
      }, 1000),
      search: _.debounce(function (val) {
        // Items have already been requested
        if (this.isLoading) return;

        if (this._.isEmpty(val)) return;
        this.isLoading = true;
        window.axios.get('http://test/customers?name=' + val)
          .then((res) => {
            if (res.data.success) {
              this.items = res.data.data;

            } else {
              this.items.push({
                name: this.search,
                phone: '',
              })
            }
          })
          .catch(err => {
            console.log(err)
          })
          .finally(() => (this.isLoading = false))
      }, 1000),
      model(newVal) {
        if (!this._.isEmpty(newVal)) {
          this.phone = newVal.phone;
        }
      }
    },
    methods: {
      addVisitors() {
        if (!this.$refs.visitorForm.validate()) {
          return;
        }
        window.axios.post('http://test/visitors', {data: this.assembleCustomers()})
          .then((res) => {
            console.log(res)
            if (res.data.success) {
              this.snackbarText = 'Thank you for request!';
              this.snackbar = true;
              location.reload();
            }
          })
          .catch(err => {
            this.snackbarText = 'Selected phone has already been taken';
            this.snackbar = true;
            console.log(err)
          })
      },
      assembleCustomers() {
        let visitors = [];
        this.customers.forEach(function (customer) {
          visitors.push({
            name: customer.name,
            phone: customer.phone ? customer.phone : 'n/a',
          });
        });
        return visitors;
      },
      addSelectedToCustomerArray() {
        if (!this.$refs.visitorForm.validate()) {
          return;
        }
        if (!this._.isEmpty(this.model) && !this._.isEmpty(this.phone))
          this.customers.push(JSON.parse(JSON.stringify({
            name: this.model.name,
            phone: this.phone,
          })));
      },
      deleteCustomer(index) {
        this.customers.splice(index, 1);
      },
    }
  }
</script>
