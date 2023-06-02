


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div class="col-xl-12 ">
            <div class="desktop-screen-design">

<!--                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Employee:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="employee_id" placeholder="Enter ID" name="employee_id" id="employee_id" class="form-control input-height" >

                            </div>
                        </div>-->
                <div  class="row mg-t-10">
                    <label class="col-sm-3 form-control-label">
                        Employee:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name / Barcode...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)">   {{c.name}}</a>
                        </li>

                    </ul>
                </div>
                    </div>
                </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                In Date:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="in_date_pre" readonly name="in_date_pre" id="in_date_pre" class="form-control input-height" >
                            </div>
                            <div  class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <input type="datetime-local" v-model="in_date" id="in_date" name="in_date" class="form-control">
                            </div>
                        </div>

                <div  class="row mg-t-10">
                    <label class="col-sm-3 form-control-label">
                        Out Date:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div  class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <input type="text" v-model="out_date_pre" readonly name="out_date_pre" id="out_date_pre" class="form-control input-height" >
                    </div>
                    <div  class="col-sm-6 mg-t-10 mg-sm-t-0">
                        <input type="datetime-local" v-model="out_date" id="out_date" name="out_date" class="form-control">
                    </div>
                </div>


                        <br><br><br>

                        <!--// BUTTONS-->
                                 <input @click="save(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">


                                <a href="/human-resource/employee-in-out-vue"><button class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br><br><br>

        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "employeeinout",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              in_date:'',
              out_date:'',
              employee_id:'',

              disableds:false,
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',
              increment_number:'',
              refreshmyinterval:false,
              in_date_pre:'',
              out_date_pre:'',
              customers:[],
              customer:'',
              alreadySearched:false,
              fkey:-1,
              ffkey:0,

          }
        },

        watch:{
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                    this.employee_id=null;
                }

                if(this.customer.length>2 && !this.alreadySearched){
                    this.customerdata();
                }
            },
        },

        methods: {
            fup(){

            },fdown(){
                console.log(1)

            },udf(event){

                if(event==0){
                    if(this.fkey!=this.customers.length){

                        this.fkey=this.fkey+1
                    }
                    $('.fba'+this.fkey +' a').focus();

                    // $('.fba'+this.fkey).focus();
                    // event.preventDefault()
                }if(event==1){

                    if(this.fkey!=-1){

                        this.fkey=this.fkey-1
                    }
                    $('.fba'+this.fkey+' a').focus();

                    // event.preventDefault()
                }




            },


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

            customerdata(){
                let v = 3;
                this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})

                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = 3;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){

                            this.employee_id = data.id;
                            this.customer = data.name;


                        this.alreadySearched=true;
                    }
                });
            },

            save:function(m){

                this.refreshmyinterval=true;
                this.disableds=true;

                let data={
                    employee_id:this.employee_id,
                    in_date:this.in_date?this.in_date:this.in_date_pre,
                    out_date:this.out_date?this.out_date:this.out_date_pre,

                };
                let url='/human-resource/employee-in-out-aeu/save';
                if(m){
                    url='/human-resource/employee-in-out-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['employee_id','in_date', 'out_date'])==0){
    this.$http.post(url,data).then(result=> {
            window.location.href = "/human-resource/employee-in-out-vue";
         //   window.location.href = "/human-resource/employee-in-out-vue";
    }).catch(error=> {
        this.disableds=false;
        this.$snotify.error('Oops, A Problem Occurred !');
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
                this.$http.get('/human-resource/employee-in-out-aeu/init'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                   if(m) {
                        this.employee_id=data.employee_id;
                       let b=data.employee_id;
                           this.customerdatavalue(b,m);

                        if(data.in=="-0001-11-30 00:00:00" || !data.in){
                            this.in_date_pre='';
                        }else{
                            this.in_date_pre=moment(data.in).format("MM/DD/YYYY, hh:mm:ss A");
                        }

                       if(data.out=="-0001-11-30 00:00:00" || !data.out){
                           this.out_date_pre='';
                       }else{
                           this.out_date_pre=moment(data.out).format("MM/DD/YYYY, hh:mm:ss A");
                       }

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

.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;

    display: block;
    color: #000;
}
.fbb a:focus{
    opacity: 1;
    background:#49a2fb;
    color: #fff;
    font-weight:bold;
}
.areabox{
    padding:0!important
}
</style>
