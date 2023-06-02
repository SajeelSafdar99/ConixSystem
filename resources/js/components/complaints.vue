


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div class="col-xl-12 ">
            <div class="desktop-screen-design">

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Subject:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="subject" placeholder="Enter Subject" name="subject" id="subject" class="form-control input-height" >

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Message:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <textarea rows="15" type="text" class="form-control" id="message" v-model="message" placeholder="Enter Complaint" autocomplete="off"></textarea>
                            </div>
                        </div>


                        <br><br><br>

                        <!--// BUTTONS-->
                                 <input @click="save(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">


                                <a href="/crm/complaints-vue"><button class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br><br><br>

        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "complaints",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              subject:'',
              message:'',

              disableds:false,
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',
              increment_number:'',
              refreshmyinterval:false,
          }
        },

        watch:{

        },

        methods: {



            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

            },
            validation: function (data, valid) {
                let self = this;
                let mm = 0;
                valid.forEach((a) => {
                    if (data[a] == '' || data[a] == null) {
                        self.$snotify.error(a + ' is required!');
                        mm++
                    }

                })
                return mm;
            },

            save:function(m){

                this.refreshmyinterval=true;
                this.disableds=true;

                let data={
                    subject:this.subject,
                    message:this.message,

                };
                let url='/crm/complaints/complaints-aeu/save';
                if(m){
                    url='/crm/complaints/complaints-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['subject','message'])==0){
    this.$http.post(url,data).then(result=> {
            window.location.href = "/crm/complaints-vue";
    }).catch(error=> {
        this.disableds=false;
        this.$snotify.error('');
    });
}
else{
    this.disableds=false;

}
            },

            scroll_left() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft -= 50;
            },
            scroll_right() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft += 50;
            },
            pluck: function (objs, name) {
        var sol = [];
        for(var i in objs){
            if(objs[i].hasOwnProperty(name)){
                // console.log(objs[i][name]);
                sol.push(objs[i][name]);
            }
        }
        return sol;
    },
          sum:  function (input){

        if (toString.call(input) !== "[object Array]")
            return false;

        var total =  0;
        for(var i=0;i<input.length;i++)
        {
            if(isNaN(input[i])){
                continue;
            }
            total += Number(input[i]);
        }
        return total;
    },
            init:function (m) {
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/crm/complaints/complaints-aeu/init'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                   if(m) {
                        this.subject=data.subject;
                        this.message=data.message;
                        this.id=data.id;
                    }
                    else{
                        this.id='';
                    }


                })

            },
        },
        mounted() {

        if(this.id){
            this.init(this.id);
            // this.init(id.id);

        }
        else{
            this.init();

        }

        }
    }
</script>

<style scoped>

</style>
