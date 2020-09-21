export default {
    data(){
        return {

        }
    },

    methods: {
        async callApi(method, url, dataObj){
            try{
               return await  axios({
                    method:method,
                    url:url,
                    data : dataObj
                });
            }catch(e){
                return e.response
            }
        },

        i (desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        
        swr (desc="Somethingn went wrong! please tye agin", title="Hey") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    },
}