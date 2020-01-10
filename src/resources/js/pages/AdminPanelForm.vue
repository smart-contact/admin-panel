<template>
    <div>
        <div style="padding-left: 200px; padding-top: 30px;" :key="n">
            <div>
                <label for="tabs">Nome</label>
                <input style="border: 1px solid grey" id="name" type="text" v-model="name">
            </div>
            <div>
                <label for="tabs">Tabs</label>
                <input style="border: 1px solid grey" id="tabs" v-on:keypress.enter="addTab()" type="text" v-model="form.tab">
                <div>{{ config.tabs.join(', ')}}</div>
                <button class="" @click="addTab()">Add Tab</button>
            </div>
            <div class="md:flex md:items-center mb-6" v-if="tabsLength">
                <label for="defaultTab">Default Tab</label>
                <select id="defaultTab" v-model="config.defaultTab">
                    <option value="--">--</option>
                    <option v-for="tab in config.tabs" :key="tab">{{ tab }}</option>
                </select>
            </div>
            <div>
                <label for="source">Source</label>
                <select id="source" v-model="source.name">
                    <option value="--">--</option>
                    <option v-for="source in sources" :key="source">{{ source }}</option>
                </select>
            </div>
            <div class="md:flex md:items-center mb-6" v-if="sourcesLength">
                <label for="divideBy">Divide By</label>
                <select id="divideBy" v-model="config.divideBy">
                    <option value="--">--</option>
                    <option v-for="column in source.columns" :key="column">{{ column }}</option>
                </select>
            </div>
            <div v-for="(filter, key, n) in config.filters">
                <label v-if="! n" for="filters">Filtri</label>
                <label>
                    <input id="filters" class="leading-tight" type="checkbox" v-model="config.filters[key]">
                    <span class="text-sm">&nbsp;&nbsp;{{ key }}</span>
                </label>
            </div>
            <div v-for="tab in config.tabs">
                <label>{{ tab }}</label>
                <div v-for="column in config.columns[tab]">
                    <p>{{ column }}</p>
                </div>
                <input type="text" v-model="form.columns[tab].value">
                <input type="text" v-model="form.columns[tab].display" v-on:keypress.enter="addColumns(tab)">
                <button @click="addColumns(tab)">Add </button>
            </div>
            <div v-for="tab in config.tabs">
                <label>{{ tab }}</label>
                <input type="text" v-model="queryForm[tab].select">
                <div>
                    <label for="select_source">From</label>
                    <select id="select_source" v-model="queryForm[tab].from">
                        <option value="--">--</option>
                        <option v-for="source in sources" :key="source">{{ source }}</option>
                    </select>
                </div>
                <label>Where</label>
                <input type="text" v-model="queryForm[tab].where">
                <label>Group By</label>
                <input type="text" v-model="queryForm[tab].groupBy">
                <label>Order By</label>
                <input type="text" v-model="queryForm[tab].orderBy">
            </div>
            <button @click="send">Salva</button>
        </div>
    </div>
</template>

<script>
    import Logo from '../../../public/img/logo.png'
    export default {
        name: "AdminPanelForm",
        props: {
            route: {
                required: true
            }
        },
        data() {
            return {
                Logo: Logo,
                name: '',
                config: {
                    tabs: [],
                    defaultTab: '',
                    divideBy: '',
                    filters: [],
                    columns: {}
                },
                queryForm: {},
                form: {
                    tab: '',
                    columns: {}
                },
                sources: [],
                source: {
                    name: '',
                    columns: []
                },
                n: 0
            }
        },

        mounted() {
            this.retrieveSources();
            this.retrieveFilters();
        },

        computed: {
            tabs() {
                return this.config.tabs;
            },
            tabsLength() {
                return this.config.tabs.length;
            },
            sourcesLength() {
              return this.sources;
            },
            sourceName() {
                return this.source.name;
            }
        },
        methods: {
            addTab() {
                if(this.form.tab) {
                    this.config.tabs.push(this.form.tab);
                }

                this.form.tab = '';
            },

            addColumns(tab) {
                this.config.columns[tab].push({[this.form.columns[tab].value]: this.form.columns[tab].display});
                this.form.columns[tab].value = '';
                this.form.columns[tab].display = '';
                this.n++;
            },

            retrieveSources() {
                axios.get('/sources')
                    .then(function({data}) {
                        this.sources = data;
                    }.bind(this))
            },

            retrieveColumnsOfSource() {
                axios.get('/source/' + this.source.name)
                    .then(function({data}) {
                        this.source.columns = data;
                    }.bind(this));
            },

            retrieveFilters() {
                axios.get('/filters')
                .then(({data}) => {
                    this.config.filters = data;
                });
            },

            send() {
                let data = {
                    'name': this.name,
                    'config': this.config,
                    'queryData': this.queryForm,
                };

                axios.post(this.route, data)
                    .then(({data}) => {
                        location.href = this.route;
                    })
            }
        },
        watch: {
            sourceName(source) {
                this.config.source = source;
                this.retrieveColumnsOfSource();
            },
            tabs(tab) {
                let value = tab[tab.length - 1];
                this.config.columns[value] = [];
                this.form.columns[value] = {
                    'value': '',
                    'display': ''
                };
                this.queryForm[value] = {
                    select: '',
                    from: '',
                    where: '',
                    groupBy: '',
                    orderBy: '',
                }
            }
        }
    }
</script>

<style scoped>

</style>
