<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <!-- Basic Info -->
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameInput" aria-describedby="nameHelp">
                        <div id="nameHelp" class="form-text">A friendly name for this plant.</div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select" aria-label="select example">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <div id="statusHelp" class="form-text">What is the current status of the plant?</div>
                    </div>

                    <div class="mb-3">
                        <label for="potSizeInput" class="form-label">Pot Size</label>
                        <input type="number" class="form-control" id="potSizeInput" aria-describedby="potSizeHelp">
                        <div id="potSizeHelp" class="form-text">How big is that pot in inches?</div>
                    </div>

                    <!-- Cross Breeding Radio Options-->
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Hybrid Settings</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="nonCross">
                                    <label class="form-check-label" for="nonCross">
                                        Non-cross
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="newCross" checked>
                                    <label class="form-check-label" for="newCross">
                                        New cross
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="crossBreedingRadio" id="crossChild" checked>
                                    <label class="form-check-label" for="crossChild">
                                        Cross Descendent
                                    </label>
                                </div>
                                <div id="hyrbidHelp" class="form-text">Where did this plant come from?</div>
                            </div>

                            <div class="mb-3">
                                <!-- Generation -->
                                <label for="filialGeneration" class="form-label">Filial Generation</label>
                                <input type="number" class="form-control" id="filialGeneration">
                                <div id="filialGenerationHelp" class="form-text">Which generation is this plant?</div>
                            </div>

                            <div class="new-cross">
                                <div class="mb-3">
                                    <!-- Relationships -->
                                    <label for="fatherParent" class="form-label">Father Plant</label>
                                    <select id="fatherParent" class="form-select" size="5" aria-label="size 5 select example">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <div id="fatherParentHelp" class="form-text">Which plant did the pollination?</div>

                                    <label for="motherParent" class="form-label">Mother Plant</label>
                                    <select id="motherParent" class="form-select" size="5" aria-label="size 5 select example">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <div id="motherParentHelp" class="form-text">Which plant did the seed grow on?</div>
                                </div>
                            </div>

                            <div class="crossChild">
                                <div class="mb-3">
                                    <label for="parent" class="form-label">Parent Plant</label>
                                    <select id="parent" class="form-select" size="5" aria-label="size 5 select example">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <div id="parentHelp" class="form-text">Which plant is this a pure descendant from?</div>
                                </div>
                            </div>

                            <div class="nonCross">
                                <div class="mb-3">
                                    <label for="species" class="form-label">Species</label>
                                    <select id="species" class="form-select" aria-label="select example">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <div id="speciesHelp" class="form-text">What is the species of this plant?</div>
                                    <p class="text-muted small">
                                        <a href="/new-species" target="_blank">New Species?</a>
                                        todo: modal
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label for="variety" class="form-label">Variety</label>
                                    <select id="variety" class="form-select" aria-label="select example">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
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

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
