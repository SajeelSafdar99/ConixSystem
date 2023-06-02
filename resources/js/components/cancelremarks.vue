


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div class="col-xl-12 ">
            <div class="desktop-screen-design">

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Desc:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="desc" placeholder="Enter Remark / Reason" name="desc" id="desc" class="form-control input-height" >

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Status:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <select  id="status" v-model="status" name="status" class="form-control" >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>


                        <br><br><br>

                        <!--// BUTTONS-->
                                 <input @click="save(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">


                                <a href="/store-management/cancellation-remarks-vue"><button class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br><br><br>

        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "cancelremarks",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              desc:'',
              status:'1',

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
                    desc:this.desc,
                    status:this.status,

                };
                let url='/store-management/cancellation-remarks/cancellation-remarks-aeu/save';
                if(m){
                    url='/store-management/cancellation-remarks/cancellation-remarks-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['desc','status'])==0){
    this.$http.post(url,data).then(result=> {
            window.location.href = "/store-management/cancellation-remarks-vue";
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
                this.$http.get('/store-management/cancellation-remarks/cancellation-remarks-aeu/init'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                   if(m) {
                        this.desc=data.desc;
                        this.status=data.status;
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
