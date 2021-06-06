<template>
    <div>
        <div class="row">
            <div class="col">
                <h3>{{ plant.name }}</h3>
                <div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th scope="row">Cross Breed</th>
                            <td>{{ plant.extra.cross_breed }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Variety</th>
                            <td>{{ plant.extra.variety }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Species</th>
                            <td>{{ plant.extra.species }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Filial Generation</th>
                            <td>{{ plant.extra.filial_generation }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>{{ plant.extra.status }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Created</th>
                            <td>{{ plant.extra.created }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <img :src="plant.extra.qr_image" alt="plant qr code"/>
            </div>
        </div>

        <div v-if="plant.extra.father || plant.extra.mother">
            <h5>Parents</h5>
            <div class="row">
                <div class="col">
                    <button v-if="plant.mother" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#mother" aria-expanded="false">Mother</button>
                    <button v-if="plant.father" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#father" aria-expanded="false">Father</button>
                </div>
            </div>

            <div class="row" v-if="plant.mother">
                <div class="col">
                    <div class="collapse multi-collapse" id="mother">
                        <div class="card card-body">
                            <tree-plant :plant="plant.mother"></tree-plant>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="plant.father">
                <div class="col">
                    <div class="collapse multi-collapse" id="father">
                        <div class="card card-body">
                            <tree-plant :plant="plant.mother"></tree-plant>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="notes">

        </div>
    </div>
</template>

<script>
export default {
    name: "TreePlant",
    props: {
        plant: Object
    }
}
</script>

<style scoped>

</style>
