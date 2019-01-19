<template>
    <div>
        <div class="alert alert-primary text-center" v-if="processing">
            <i class="fa fa-compass"></i> Procesando petición...
        </div>
        <v-server-table ref="table" :columns="columns" :url="url" :options="options">
            <div slot="activate_deactivate" slot-scope="props">
                <button
                    v-if="parseInt(props.row.estado) === 2" 
                    type="button"
                    class="btn btn-success btn-block"
                    @click="updateEstado(props.row, 1)"
                >
                    <i class="fa fa-check"></i> {{ labels.topost }}
                </button>
                <button
                    v-else
                    type="button"
                    class="btn btn-danger btn-block"
                    @click="updateEstado(props.row, 2)"
                >
                    <i class="fa fa-close"></i> {{ labels.unsubscribe }}
                </button>
            </div>

            <div slot="estado" slot-scope="props">
                {{ formattedEstado(props.row.estado) }}
            </div>

            <div slot="filter__estado" @change="filterByEstado">
                <select class="form-control" v-model="estado">
                    <option selected value="0">Selecciona una opción</option>
                    <option value="1">Publicado</option>
                    <option value="2">Pendiente</option>
                </select>
            </div>

        </v-server-table>
    </div>
</template>

<script>
    import {Event} from 'vue-tables-2';
    export default {
        name: "courses",
        props: {
            labels: {
                type: Object,
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },
        data () {
            return {
                processing: false,
                estado: null,
                url: this.route,
                columns: ['id', 'nombre', 'estado', 'activate_deactivate'],
                options: {
                    filterByColumn: true,
                    perPage: 10,
                    perPageValues: [10, 25, 50, 100, 500],
                    headings: {
                        id: 'ID',
                        nombre: this.labels.nombre,
                        estado: this.labels.estado,
                        activate_deactivate: this.labels.activate_deactivate,
                        topost: this.labels.topost,
                        unsubscribe: this.labels.unsubscribe
                    },
                    customFilters: ['estado'],
                    sortable: ['id', 'nombre', 'estado'],
                    filterable: ['nombre'],
                    requestFunction: function (data) {
                        return window.axios.get(this.url, {
                            params: data
                        })
                        .catch(function (e) {
                            this.dispatch('error', e);
                        }.bind(this));
                    }
                }
            }
        },
        methods: {
            filterByEstado () {
                parseInt(this.estado) !== 0 ? Event.$emit('vue-tables.filter::estado', this.estado) : null;
            },
            formattedEstado (estado) {
                const estados = [
                    null,
                    'Publicado',
                    'Pendiente'
                ];
                return estados[estado];
            },
            updateEstado(row, newEstado){
                this.processing = true;

                setTimeout(() => {
                    this.$http.post('/admin/courses/updateEstado',
                        {courseId: row.id, estado: newEstado},
                        {
                            headers: {
                                'x-csrf-token': document.head.querySelector('meta[name=csrf-token]').content
                            }
                        }
                    )
                        .then(response => {
                            this.$refs.table.refresh();
                        })
                        .catch(error => {

                        })
                        .finally(() => {
                            this.processing = false;
                        });
                }, 1500);
            }
        }
    }
</script>

<style>
    .table-bordered>thead>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>tfoot>tr>td {
        text-align: center !important;
    }
</style>
