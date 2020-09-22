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
                                <div class="col-3">Email</div>
                                <div class="col-9">
                                    <label>{{data.email}}</label>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3">Score</div>
                                <div class="col-9">
                                    <label>{{data.score}}</label>
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

                }
            }
        },
        
        async created(){
                /* 
            const [user, record] = await Promise.all([
                this.callApi('get', '/app/get_user'), //경로
                this.callApi('get', '/app/get_record'),
            ])
            if(user.status==200){
                this.users = user.data
                this.records = record.data
            }else{
                this.swr()
            } */

            const record = await this.callApi('get','app/get_record')

            this.users=record.data

        },

    }

</script>