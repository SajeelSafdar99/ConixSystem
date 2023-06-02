<template>
<div>
    <vue-snotify></vue-snotify>

    <div class="row hidden-print">


        <div class="col-lg">
            <div>
                <datepicker v-model="start_date" :clear-button="true" placeholder="From Call Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
            </div>
        </div>
        <div class="col-lg">
            <div>
                <datepicker v-model="end_date" :clear-button="true"  placeholder="To Call Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>
        </div>



            <div class="col-sm-4">
                <multiselect track-by="name" label="name" placeholder="Choose BD" v-model="user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>


        <div class="col-sm-2">
            <button type="button" @click="init();" class="btn btn-success">Search</button>
        </div>
    </div>


    <br>
    <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
        <h5>AFOHS <br>BD REPORT </h5>
    </div>

    <div class="blackcolor headingsetting ">
        <div class="scrollclasstable1">

            <div>

                <table class="myFormat table-hover" style="width: 100%;">
                    <tbody>

                    <tr style="border-bottom: 2px solid black;" class="head">
                        <td><STRONG>SR #</STRONG></td>
                        <td><STRONG>ID</STRONG></td>
                        <td><STRONG>BD NAME</STRONG></td>
                        <td><STRONG>TOTAL CALLS</STRONG></td>
                        <td><STRONG>TOTAL FOLLOW-UPS</STRONG></td>
                        <td><STRONG>TOTAL VISITS</STRONG></td>
                        <td><STRONG>TOTAL APPEARED VISITS</STRONG></td>
                        <td><STRONG>TOTAL NOT INTERESTED</STRONG></td>
                    </tr>

                    <template v-for="(s,key) in  sliceP(
                     (()=>{
                      let  x=leads;

                     return x;
                    })()

                    )">

                        <tr>
                            <td>{{((page-1)*pagelength)+key+1}}</td>
                            <td>{{s.assigned_to}}</td>
                            <td>{{s.username}}</td>
                            <td>{{s.callss | numFormat }}</td>
                            <td>{{s.follows | numFormat }}</td>
                            <td>{{s.visits | numFormat }}</td>
                            <td>{{s.appeared | numFormat }}</td>
                            <td>{{s.ninterested | numFormat }}</td>
                        </tr>

                    </template>

                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr style="border: 2px solid black;">
                        <td></td>
                        <td class="text-center" colspan="2"><STRONG>GRAND TOTAL:</STRONG></td>
                        <td>{{totalcal | numFormat}}</td>
                        <td>{{totalfol | numFormat}}</td>
                        <td>{{totalvis | numFormat}}</td>
                        <td>{{totalapp | numFormat}}</td>
                        <td>{{totalni | numFormat}}</td>
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
                <br>
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
.border {
    border: 26px solid white !important;
    background-color: black;
    color: yellow;
    padding: 15px;
    text-align: center;
    font-weight: 900;
}
table.myFormat tr td {
    font-size: 17px !important;
    width: 5%;
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
.cat{
    background: #ffff;
    font-weight: bold;
    padding: 9px 0 9px;
}
.sub{
  /*  border-top: 1px solid #000!important;*/
    text-align: center;
    font-weight: bold;
    padding: 0 0 20px;
}

</style>
<script>
import Datepicker from 'vuejs-datepicker';
    export default {
        name: "bdreport",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                page:1,
                keysss:0,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                leads:[],
                leadsR:[],
                leadsM: [],
                start_date:'',
                end_date:'',
                users:[],
                user:[],
                totalvis:'',
                totalcal:'',
                totalfol:'',
                totalapp:'',
                totalni:'',
                getRe:false,
            }
        },
        /*computed: {
            totals() {
                let  x=this.filterData(this.leads);

                let totalvis=0;
                let totalcal=0;
                let totalfol=0;
                let totalapp=0;
                let totalni=0;

                x.forEach(function (item) {
                    totalvis=totalvis + parseInt(item.visits?item.visits:0);
                    totalcal=totalcal + parseInt(item.callss?item.callss:0);
                    totalfol=totalfol + parseInt(item.follows?item.follows:0);
                    totalapp=totalapp + parseInt(item.appeared?item.appeared:0);
                    totalni=totalni + parseInt(item.ninterested?item.ninterested:0);
                })
                return {
                    totalvis:totalvis,
                    totalcal:totalcal,
                    totalfol:totalfol,
                    totalapp:totalapp,
                    totalni:totalni,
                }
            }
        },*/
        methods:{
            filterData(leads){
             let   x=leads;

                if(this.user.length>0){
                    x=x.filter((a)=>{return this.user.filter((m)=>{
                        return a.assigned_to==m.id;
                    }).length>0});
                }

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.call_time,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    x=x.filter((a)=>{return moment(a.call_time,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
                }

                else{
                    x=x;
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
            init:function () {

                let x='';
                if(this.user){
                    x+='&user='+this.pluck(this.user,'id').join(',');
                }  if(this.start_date){
                    x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }  if(this.end_date){
                    x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
                }if(true){
                    x+='&r='+1;
                }
                this.$http.get('/finance-and-management/reports/bd-report/bd_init_vue?1=1'+x).then(result=>{
                    let data=result.data;
                    if(!data.leads){
                        data.leads=[];
                    }


                        let a=0;
                        let b=0;
                        let c=0;
                        let d=0;
                        let e=0;

                        let x=data.leads;
                        //console.log(1);
                        x.forEach(function (s,key) {
                            a=a+parseInt(s.visits);
                            b=b+parseInt(s.callss);
                            c=c+parseInt(s.follows);
                            d=d+(parseInt(s.appeared));
                            e=e+(parseInt(s.ninterested));

                        })
                        this.totalvis=a
                        this.totalcal=b
                        this.totalfol=c
                        this.totalapp=d
                        this.totalni=e


                    this.leads=data.leads;
                    this.leadsR=data.leads;
                    this.leng=data.leads.length;
                    this.users=data.users;
                    this.getRe=true;

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

        },
        mounted() {
            if(this.id){
              //  this.init(this.id);

                // this.init(id.id);

            }
            else{
                //this.init();

            }

            this.start_date=new Date();
            this.end_date=new Date();
            this.init();
        }
    }
</script>

