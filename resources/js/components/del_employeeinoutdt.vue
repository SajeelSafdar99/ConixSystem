<template>
    <div>
        <vue-snotify></vue-snotify>


        <div class="row hidden-print">


            <div class="col-lg">
                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">
            </div>

            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="in_date" :clear-button="true" placeholder="In (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="in_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="out_date" :clear-button="true" placeholder="Out (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="out_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="deleted_date" :clear-button="true" placeholder="Deleted At (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="deleted_date"></datepicker>
                </div>
            </div>


<!--            <div class="col-xs">
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "(()=>{return filterData(employees)})()"
                    worksheet = "My Worksheet"
                    name    = "Complaints.xls">
                </export-excel>
            </div>-->

        </div>

<br>
        <div class="scrollclasstable1">
            <div>
                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">EMPLOYEE ID</th>
                        <th class="wd-30p">EMPLOYEE NAME</th>
                        <th class="wd-20p">IN</th>
                        <th class="wd-20p">OUT</th>
                        <th class="wd-20p">DELETED AT</th>
                        <th class="wd-5p hidden-print">RESTORE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(employees);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.employee_id}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{moment(tr.in).format('DD/MM/YYYY hh:mm:ss A')}}</td>
                        <td>{{moment(tr.out).format('DD/MM/YYYY hh:mm:ss A')}}</td>
                        <td>{{moment(tr.deleted_at).format('DD/MM/YYYY hh:mm:ss A')}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Restore"><a style="color:#000000;" :href="'/human-resource/employee-in-out/restore/' + tr.id"><i class="fas fa-trash-restore"></i></a></button></td>
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
                                <option :value="employees.length" >ALL</option>
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
.svg-inline--fa.fa-w-10 {
    width: 1.625em;
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
    name: "del_employeeinoutdt",
    components: {
        Datepicker
    },
    props: [],
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            employees:[],
            employeesR:[],
            employeesM: [],
            memberid:'',
            in_date:'',
            out_date:'',
            deleted_date:'',
        }
    },

    methods:{
        filterData(employees){
            let   x=employees;

            if(this.memberid){
                x=x.filter((a)=>{return a.employee_id==this.memberid});
            }
            if(this.in_date){
                x=x.filter((a)=>{return moment(a.in,'YYYY-MM-DD').format('x')==moment(moment(this.in_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.out_date){
                x=x.filter((a)=>{return moment(a.out,'YYYY-MM-DD').format('x')==moment(moment(this.out_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.deleted_date){
                x=x.filter((a)=>{return moment(a.deleted_at,'YYYY-MM-DD').format('x')==moment(moment(this.deleted_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(employees){
            // console.log(123);
            this.employeesM=employees;
            return  employees.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },

        /* FOR DATE PICKER*/

        /*  customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
          //  use as :format="customFormatter"
        },*/

        init:function () {

            this.$http.get('/human-resource/employee-in-out/indexdt_deleted').then(result=>{
                let data=result.data;

                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
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
            this.init(this.id);

            // this.init(id.id);

        }
        else{
            this.init();

        }

    }
}
</script>

