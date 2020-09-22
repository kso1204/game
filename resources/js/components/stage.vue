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

                        <button type="button"
                             @click="resetModal=true" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Reseting" : "Reset" }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stage</div>

                    <div class="card-body">
                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Healing</div>
                            <div class="col-9"><button type="button"
                             @click="healing" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Healing" : "Heal" }}</button></div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Attack</div>
                            <div class="col-9"><button type="button"
                             @click="attack" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Attacking" : "Attack" }}</button></div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Skill Q</div>
                            <div class="col-9"><button type="button"
                             @click="skillOne" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Attacking" : "Q" }}</button></div>
                        </div>
                        
                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Skill W</div>
                            <div class="col-9"><button type="button"
                             @click="skillTwo" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Attacking" : "W" }}</button></div>
                        </div>
                        
                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Skill E</div>
                            <div class="col-9"><button type="button"
                             @click="skillThree" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Attacking" : "E" }}</button></div>
                        </div>

                        <div class="row" style="margin-top:20px;">
                            <div class="col-3" style="padding-top:5px;">Skill R</div>
                            <div class="col-9"><button type="button"
                             @click="skillFour" :loading="isAttack" :disabled="isAttack"
                              class="btn btn-primary">{{ isAttack? "Attacking" : "R" }}</button></div>
                        </div> 
                    </div>
                </div>
            </div>

            
            <Modal
                v-model="resetModal"
                title="Reset?!"
                :mask-closable = "false"
                :closable = "false"
                >
                 <div style="text-align:center">
                        <p>After this task is reseted, the level will be 1 and reset count + 1 and Game Count 0 </p>
                        <p>Will you reseted it?</p>
                    </div>

                <div slot="footer">
                    <Button type="error" @click="resetModal=false">close</Button>
                    <Button type="primary" @click="reset" :disabled="isAttack" :loading="isAttack" >{{ isAttack? "Reseting.." : "Reset" }}</Button>
                </div>
            </Modal>
    </div>
</template>


<script>


    
    export default {

          props: ['user'],

        data(){
            return {
                data :{

                },
                isAttack:false,
                resetModal:false,
            }
        },
        
        created(){
            this.data = this.user;
        },

	    methods :{
            async healing(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/heal',this.data)

                if(res.status==200)
                {
                      this.i(res.data.msg);      
                      this.data=res.data.user[0]; 
                      this.isAttack = false     
                }
                else{
                    this.swr();
                }
            },
            async attack(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/attack',this.data)

                if(res.status==200)
                {
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false     
                        /* const res2 = await this.callApi('get', `app/get_user/${this.id}`)
                        if(res2.status==200)
                        {
                            this.data=res2.data[0]
                        }     */ 
                }
                else{
                    this.swr();
                }
            },
            async skillOne(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/skillOne',this.data)

                if(res.status==200)
                {
                            
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false      
                }
                else{
                    this.swr();
                }
            },
            async skillTwo(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/skillTwo',this.data)

                if(res.status==200)
                {
                            
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false      
                }
                else{
                    this.swr();

                }
            },
            async skillThree(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/skillThree',this.data)

                if(res.status==200)
                {
                            
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false      
                }
                else{
                    this.swr();

                }
            },
            async skillFour(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/skillFour',this.data)

                if(res.status==200)
                {
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false      
                }
                else{
                    this.swr();
                }
            },
            async reset(){
                this.isAttack = true
                const res = await this.callApi('post', 'app/reset',this.data)

                if(res.status==200)
                {
                      this.i(res.data.msg);     
                      this.data=res.data.user[0]; 
                      this.isAttack = false      
                }
                else{
                    this.swr();
                }
            },
        }
    }

</script>