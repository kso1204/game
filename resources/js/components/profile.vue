<template>
<div class="row justify-content-center">
        
        <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Profile</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">Name</div>
                                <div class="col-9" >
                                    <label>{{data.name}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">Level</div>
                                <div class="col-9">

                                    <label>{{data.level}}</label>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3">Exp</div>
                                <div class="col-9">

                                    <label>{{data.exp}}</label>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3">hp</div>
                                <div class="col-9">

                                    <label>{{data.hp}}</label>

                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-3">Die Count</div>
                                <div class="col-9">

                                    <label>{{data.die}}</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">Game Count</div>
                                <div class="col-9">

                                    <label>{{data.cnt}}</label>

                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col-3">Reset Count</div>
                                <div class="col-9">

                                    <label>{{data.reset}}</label>

                        
                                </div>
                            </div>
                        </div>
                    </div>
                
        </div>
    </div>
</template>


<script>



export default {

        props: ['user'],

    data(){
        return {
            data :{

            },
        }
    },
    
    created(){
        this.data = this.user;
    },
}

</script>