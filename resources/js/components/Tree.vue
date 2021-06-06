<template>
    <div>
        <tree-plant v-if="plant !== null" :plant="plant"></tree-plant>
    </div>
</template>

<script>

import TreePlant from "./TreePlant";

export default {
    name: "Tree",
    components: {TreePlant},
    props: {
        plantId: Number
    },
    data: () => ({
        plant: null
    }),
    mounted() {
        axios.get('api/plant/' + this.plantId + '/family-tree').then((response) => {
            this.plant = response.data;
        })
    },
    methods: {

    }
}
</script>

<style>
    .linage {
        fill: none;
        stroke: black;
    }
    .marriage {
        fill: none;
        stroke: black;
    }
    .node {
        background-color: lightblue;
        border-style: solid;
        border-width: 1px;
    }
    .nodeText{
        font: 10px sans-serif;
    }
    .marriageNode {
        background-color: black;
        border-radius: 50%;
    }




    .linage {
        fill: none;
        stroke: #000;
    }
    .marriage {
        fill: none;
        stroke: black;
    }
    .marriageNode {
        background-color: black;
        border-radius: 50%;
    }
    .man {
        background-color: lightblue;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
    }
    .woman {
        background-color: pink;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
    }
    .emphasis{
        font-style: italic;
    }
    p {
        padding:0;
        margin:0;
    }
    svg {
        border-style: solid;
        border-width: 1px;
    }
</style>
