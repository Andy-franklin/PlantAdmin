<template>
    <div class="container mt-5">
        <loader v-show="loading"></loader>
        <div v-show="!loading" class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <div class="alert alert-danger mb-3 mt-3" role="alert" v-show="error.active">
                        {{ error.message }}
                    </div>

                    <!-- Basic Info -->
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" v-model="form.name">
                        <div id="nameHelp" class="form-text">A friendly name for this plant.</div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select" aria-label="select example" v-model="form.status_id">
                            <option v-for="(status, index) in formOptions.statuses" :value="index">{{ status }}</option>
                        </select>
                        <div id="statusHelp" class="form-text">What is the current status of the plant?</div>
                    </div>

                    <div class="mb-3" v-show="undefined !== formOptions.statuses && formOptions.statuses[form.status_id] === 'Potted'">
                        <label for="potSizeInput" class="form-label">Pot Size</label>
                        <input type="number" class="form-control" id="potSizeInput" aria-describedby="potSizeHelp" v-model="form.pot_size">
                        <div id="potSizeHelp" class="form-text">How big is that pot in inches?</div>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" aria-describedby="quantityHelp" v-model="form.quantity">
                        <div id="quantityHelp" class="form-text">How many do you have? (How many is too many?)</div>
                    </div>

                    <hr/>

                    <!-- Cross Breeding Radio Options-->
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Hybrid Settings</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="nonCross" value="nonCross" checked v-model="form.crossBreedingInfo">
                                    <label class="form-check-label" for="nonCross">
                                        Non-cross
                                    </label>
                                </div>
                                <div class="form-check" v-if="formOptions.plants !== undefined && formOptions.plants.length > 0">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="newCross" value="newCross" v-model="form.crossBreedingInfo">
                                    <label class="form-check-label" for="newCross">
                                        New cross
                                    </label>
                                </div>
                                <div class="form-check" v-if="formOptions.plants !== undefined && formOptions.plants.length > 0">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="crossChild" value="crossChild" v-model="form.crossBreedingInfo">
                                    <label class="form-check-label" for="crossChild">
                                        Cross Descendent
                                    </label>
                                </div>
                                <div id="hyrbidHelp" class="form-text">Where did this plant come from?</div>
                            </div>

                            <div class="mb-3">
                                <!-- Generation -->
                                <label for="filialGeneration" class="form-label">Filial Generation</label>
                                <input type="number" class="form-control" id="filialGeneration" v-model="form.filial_generation">
                                <div id="filialGenerationHelp" class="form-text">Which generation is this plant?</div>
                            </div>

                            <div class="new-cross" v-if="form.crossBreedingInfo === 'newCross'">
                                <div class="mb-3">
                                    <!-- Relationships -->
                                    <label for="fatherParent" class="form-label">Father Plant</label>
                                    <select id="fatherParent" class="form-select" size="5" aria-label="size 5 select example" v-model="form.father_plant_id">
                                        <option v-for="(plant, index) in formOptions.plants" :value="plant.id">{{ plant.name }}</option>
                                    </select>
                                    <div id="fatherParentHelp" class="form-text">Which plant did the pollination?</div>

                                    <label for="motherParent" class="form-label">Mother Plant</label>
                                    <select id="motherParent" class="form-select" size="5" aria-label="size 5 select example" v-model="form.mother_plant_id">
                                        <option v-for="(plant, index) in formOptions.plants" :value="plant.id">{{ plant.name }}</option>
                                    </select>
                                    <div id="motherParentHelp" class="form-text">Which plant did the seed grow on?</div>
                                </div>
                            </div>

                            <div class="crossChild" v-if="form.crossBreedingInfo === 'crossChild'">
                                <div class="mb-3">
                                    <label for="parent" class="form-label">Parent Plant</label>
                                    <select id="parent" class="form-select" size="5" aria-label="size 5 select" v-model="form.parent_plant_id">
                                        <option v-for="(plant, index) in formOptions.plants" :value="plant.id">{{ plant.name }}</option>
                                    </select>
                                    <div id="parentHelp" class="form-text">Which plant is this a pure descendant from?</div>
                                </div>
                            </div>

                            <div class="nonCross" v-if="form.crossBreedingInfo === 'nonCross'">
                                <div class="mb-3">
                                    <label for="species" class="form-label">Species</label>
                                    <select id="species" class="form-select" aria-label="select" v-model="species_id">
                                        <option v-for="(species, index) in formOptions.species" :value="index">{{ species }}</option>
                                    </select>
                                    <div id="speciesHelp" class="form-text">What is the species of this plant?</div>
                                    <p class="text-muted small">
                                        <a href="/new-species" target="_blank">New Species?</a>
                                        todo: modal
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label for="variety" class="form-label">Variety</label>
                                    <select id="variety" class="form-select" aria-label="select" v-model="form.variety_id">
                                        <option v-for="(variety, index) in varieties" :value="variety.id">{{ variety.name }}</option>
                                    </select>
                                    <div id="varietyHelp" class="form-text">And which variety is it?</div>
                                    <p class="text-muted small">
                                        <a href="/new-variety" target="_blank">New Variety?</a>
                                        todo: modal
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button @click="submit" type="button" class="mt-3 mb-3 btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "../components/Loader";
import router from "../router";

export default {
    components: {Loader},
    watch: {
        species_id: function() {
            this.form.species_id = this.species_id;
            this.varieties = [];

            for (let i = 0; i < this.formOptions.varieties.length; i++) {
                if (this.formOptions.varieties[i].species_id == this.form.species_id) {
                    this.varieties.push(this.formOptions.varieties[i]);
                }
            }
        }
    },
    data() {
        return {
            loading: true,
            varieties: [],
            species_id: null,
            error: {
                active: false,
                message: '',
                form: {}
            },
            form: {
                name: null,
                status_id: null,
                pot_size: null,
                filial_generation: null,
                species_id: null,
                variety_id: null,
                parent_plant_id: null,
                mother_plant_id: null,
                father_plant_id: null,
                crossBreedingInfo: 'nonCross',
                quantity: 1
            },
            formOptions: {}
        }
    },
    mounted() {
        axios.options('/api/plant/create')
            .then((response) => {
                this.formOptions = response.data;

                this.loading = false;
            })
            .catch(function (error) {
                console.log(error);
            })
    },
    methods : {
        submit : function(){
            this.loading = true;
            axios.post('/api/plant/create', this.form)
                .then((response) => {
                    this.loading = false;

                    router.push({name: 'home'})

                })
                .catch((error) => {
                    debugger;
                    this.loading = false;
                    this.error.active = true;
                    this.error.message = error.response.data.message;
                    this.error.form = error.response.data.errors;
                })
        }
    }
}
</script>
