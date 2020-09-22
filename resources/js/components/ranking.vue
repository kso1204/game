<template>
<div class="row justify-content-center">
        
        <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Ranking</div>
                        
                        <div class="card-body" v-for="(data,i) in users" :key="i" :v-if="users.length">
                            <div class="row">
                                <div class="col-3">Ranking No.</div>
                                <div class="col-9" >
                                    <label>{{i+1}}</label>
                                </div>
                            </div>
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
                                <div class="col-3">Count</div>
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

        data(){
            return {
                users :{

                },
                isAttack:false,
            }
        },
        
        async created(){
            const res = await this.callApi('get', 'app/get_user')
            console.log(res)
            this.users = res.data;
        },

    }

</script>