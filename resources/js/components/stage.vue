<template>
<div class="row justify-content-center">
        
        <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Profile</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">Email</div>
                                <div class="col-9" >
                                    <label>{{data.email}}</label>
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
                        </div>
                    </div>
                </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stage</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">Attack</div>
                            <div class="col-9"><button type="button" @click="attack" class="btn btn-primary">Attack</button></div>
                        </div>
                    </div>
                </div>
            </div>
    
    </div>
</template>


<script>


import {mapGetters} from 'vuex'
    
    export default {

          props: ['user'],

        data(){
            return {
                data :{

                },
                isAttack:false,
                id:null,
            }
        },
        
        async created(){
            this.id = this.user.id;
            const res = await this.callApi('get', `app/get_user/${this.id}`)
            if(res.status==200)
            {
                this.data=res.data[0]
                console.log(this.data)
                console.log(res.data)
            }
        },

	    methods :{
            async attack(){
                const res = await this.callApi('post', 'app/attack',this.data)

                if(res.status==200)
                {

                }
                else{

                }
            }
        }
    }

</script>