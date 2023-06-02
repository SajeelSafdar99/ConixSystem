<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="hidden-print">
            <v-offline
                online-class="online"
                offline-class="offline"
                @detected-condition="amIOnline">
                <template v-slot:[onlineSlot] :slot-name="onlineSlot">
                    ( Online: {{ onLine }} )
                </template>
                <template v-slot:[offlineSlot] :slot-name="offlineSlot">
                    ( Online: {{ onLine }} )
                </template>
            </v-offline>
            <br>
        </div>

        <div class="row hidden-print">


            <div class="col-lg">
                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">
            </div>
            <div class="col-lg">
                <div>
                    <datepicker v-model="call_date" :clear-button="true" placeholder="Call Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="call_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker v-model="follow_up_date" :clear-button="true"  placeholder="Follow Up Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="follow_up_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <input value="" class="form-control "  size="20" type="number"
                       id="leadid" v-model="leadid" autocomplete="off"
                       name="leadid" placeholder="Search by Lead ID">
            </div>

            <div class="col-lg">
                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="name" v-model="name"
                       name="name" placeholder="Search by Name">
            </div>

        </div>
        <br>
        <div class="row hidden-print">
            <div class="col-lg">
                <!-- <p style="color: black;">Status:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Status" v-model="status" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose BD" v-model="user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>
            <div class="col-xs">
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "(()=>{return filterData(leads)})()"
                    worksheet = "My Worksheet"
                    name    = "CallDetails.xls">
                </export-excel>
            </div>

        </div>

<br>
        <div class="scrollclasstable1">
            <div>
                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">ID</th>
                        <th class="wd-5p">LEAD ID</th>
                        <th class="wd-25p">CUSTOMER NAME</th>
                        <th class="wd-15p">CALL STATUS</th>
                        <th class="wd-10p">CALL DATE & TIME</th>
                        <th class="wd-10p">FOLLOW UP DATE & TIME</th>
                        <th class="wd-30p">REMARKS</th>
                        <th class="wd-20p">BD</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                      (()=>{
                      let  x=filterData(leads);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{key+1}}</td>
                        <td>{{tr.id}}</td>
                        <td>{{tr.lead_id}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.status}}</td>
                        <template v-if="tr.call_time && tr.call_time!='0000-00-00 00:00:00'"><td>{{moment(tr.call_time).format('DD/MM/YYYY HH:mm:ss')}}</td></template>
                        <template v-else><td></td></template>
                        <template v-if="tr.follow_up && tr.follow_up!='0000-00-00 00:00:00'"><td>{{moment(tr.follow_up).format('DD/MM/YYYY HH:mm:ss')}}</td></template>
                        <template v-else><td></td></template>
                        <td>{{tr.remarks}}</td>
                        <td>{{users.filter(function(a){return a.id==tr.user}).length>0?users.filter(function(a){return a.id==tr.user})[0].name:''}}</td>
                     </tr>

                    </tbody>

                </table>
                <div class="hidden-print">
                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="leads.length" >ALL</option>
                            </select>
                        </li>  </ul>
                </div>

            </div>
        </div>


    </div>
</template>
<style>
.vdp-datepicker__clear-button{

    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 20px;
    color: #000;

}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.svg-inline--fa.fa-w-9 {
    width: 1.5625em;
}
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
}
.pagination li {
    padding: 5px 10px;
    border: 1px solid #0a4177;
    margin-right: 2px;
    /* border-radius: 50%; */
    /* height: 40px; */
    /* width: 40px; */
    text-align: center;

    cursor: pointer;
    transition: all 0.3s;
}
.pagination li.active{
    background: #49a2fb;
    color: #fff;
}
.pagination li:hover{
    background: #49a2fb;
    color: #fff;
}

.groove{
    overflow: auto;
    height: 300px !important;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
/*table thead th{
    position: sticky;
    top: 80px;
    background: #000;
}*/
table th{
    background:#0c3661;
    height: 50px !important;
}
table tfoot{
    background:#0c91ed;
}
table tfoot td{
    color :black !important;
    height: 30px !important;

}

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
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "calldetailsdt",
    components: {
        Datepicker
    },
    props: [],
    json_data: [],
    data(){
        return{
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            leads:[],
            leadsR:[],
            leadsM: [],
            barcode:'',
            memberid:'',

            stati:[],
            status:[],
            fkey:-1,
            ffkey:0,
            users:[],
            user:[],

            remarks:'',
            call_status:'1',
            call_date:'',
            follow_up_date:'',
            json_data: [],
            leadid:'',
            name:'',
        }
    },

    methods:{
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
        filterData(leads){
            let   x=leads;

            if(this.memberid){
                x=x.filter((a)=>{return a.id==this.memberid});
            }
            if(this.leadid){
                x=x.filter((a)=>{return a.lead_id==this.leadid});
            }

            if(this.name){
                x=x.filter((a)=>{
                    let self=this;
                    return (String(a.name)).toLowerCase().startsWith(self.name.toLowerCase())});
            }

            if(this.call_date){
                x=x.filter((a)=>{return moment(a.call_time,'YYYY-MM-DD').format('x')==moment(moment(this.call_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if(this.follow_up_date){
                x=x.filter((a)=>{return moment(a.follow_up,'YYYY-MM-DD').format('x')==moment(moment(this.follow_up_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }


            if(this.status.length>0){
                x=x.filter((a)=>{return this.status.filter((m)=>{
                    return a.status==m.name;
                }).length>0});
            }

            if(this.user.length>0){
                x=x.filter((a)=>{return this.user.filter((m)=>{
                    return a.user==m.id;
                }).length>0});
            }

            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(leads){
            // console.log(123);
            this.leadsM=leads;
            return  leads.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },


        /* FOR DATE PICKER*/

        /*  customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
          //  use as :format="customFormatter"
        },*/

        init:function () {

            this.$http.get('/crm/call-details/calls_init_vue').then(result=>{
                let data=result.data;

                this.leads=data.leads;
                this.leadsR=data.leads;
                this.leng=data.leads.length;
             //   this.json_data=data.leads;
                this.stati=data.stati;
                this.users=data.users;
            })
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
        amountChange:function(k,e){
            if(parseInt(e.target.value)>parseInt(e.target.max)){
                this.invoices[k].p=e.target.max;
            }
        }
        ,
        validation:function(data,valid){
            let self=this;
            let  mm=0;
            valid.forEach((a)=> {
                if(data[a]=='' || data[a]==null){
                    self.$snotify.error(a+' is required!');
                    mm++
                }

            })
            return mm;
        },
    },
    watch:{
        leadsM:function(){
            console.log(1);
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
        this.call_date=new Date();

    }
}
</script>

