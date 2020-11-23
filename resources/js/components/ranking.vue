<template>
<div class="row justify-content-center">
        
        <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Ranking</div>
                        
                        <div class="card-body" v-for="(record,i) in records.data" :key="i" :v-if="records.length">
                            <div class="row">
                                <div class="col-3">Ranking No.</div>
                                <div class="col-9" >
                                    <label>{{i+1}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">Name</div>
                                <div class="col-9" >
                                    <label>{{record.data.attributes.users.data.attributes.name}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">Email</div>
                                <div class="col-9">
                                    <label>{{record.data.attributes.users.data.attributes.email}}</label>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3">Score</div>
                                <div class="col-9">
                                    <label>{{record.data.attributes.score}}</label>
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
                records :{

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
            this.records = record.data
            
            //this.users=record.data

            

        },

    }

</script>