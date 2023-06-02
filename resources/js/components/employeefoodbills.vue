<template>
    <div>
        <vue-snotify></vue-snotify>


        <div class="row  hidden-print">
            <div class="col-sm-1">
                <div>

                   <select class="form-control" v-model="year">
                       <option>2020</option>
                       <option>2021</option>
                   </select>
                </div>
            </div>
            <div class="col-sm-1">
                <div>

                    <select class="form-control" v-model="month">
                        <option v-for="n in 12">{{moment(n, 'M').format('MMMM')}}</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-1">

                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="employee_id" v-model="employee_id"
                       name="employee_id" placeholder="Search ID">
            </div>

            <div class="col-lg">

                    <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                        <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                            <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                                <a href="javascript:void(0)">   {{c.name}}</a>
                            </li>

                        </ul>
                    </div>
            </div>

<!--            <div class="col-lg">
                <div>
                    <p style="color: black;">Company:</p>
                    <select v-model="company"  class="form-control">
                        <option value="0">All</option>
                        <option v-for="com in companies" :value="com.desc">{{com.desc}}</option>
                    </select>
                </div>
            </div>
             <div class="col-lg">
            <div>
                <p style="color: black;">Department:</p>
                <select v-model="department"  class="form-control">
                    <option value="0">All</option>
                    <option v-for="dep in departments" :value="dep.desc">{{dep.desc}}</option>
                </select>
            </div>
        </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Sub-Department:</p>
                    <select v-model="subdepartment"  class="form-control">
                        <option value="0">All</option>
                        <option v-for="sub in subdepartments" :value="sub.desc">{{sub.desc}}</option>
                    </select>
                </div>
            </div>-->


            <div class="col-lg">

                    <multiselect track-by="name" label="name" placeholder="Choose Companies" v-model="company" :multiple="true" :options="(()=>{let x=[];
            companies.forEach((a)=>{
                x.push({name:a.name,id:a.code})
            })
            return x;
            })()"></multiselect>
            </div>
            <div class="col-lg">

                    <multiselect track-by="name" label="name" placeholder="Choose Departments" v-model="department" :multiple="true" :options="(()=>{
            let x=[];
                departments.filter((a)=>{
                    if(company.length>0){
                        return pluck(company,'id').indexOf((a.company))!=-1
                    } else{
                        return true;
                    } } ).forEach((a)=>{
                        x.push({name:a.desc,id:a.id})
                })
                return x;
            })()"></multiselect>
            </div>
            <div class="col-lg">

                <multiselect track-by="name" label="name" placeholder="Choose Sub-departments" v-model="subdepartment" :multiple="true" :options="(()=>{
            let x=[];
                subdepartments.filter((a)=>{
                    if(department.length>0){
                        return pluck(department,'id').indexOf(parseInt(a.department))!=-1
                    } else{
                        return true;
                    } } ).forEach((a)=>{
                        x.push({name:a.desc,id:a.id})
                })
                return x;
            })()"></multiselect>
            </div>



        </div>
        <div class="row  hidden-print">

            <div class="col-sm-2">
                <div>
                    <select v-model="ent"  class="form-control">
                        <option v-for="s in ['Include ENT and CTS','Exclude ENT and CTS','Only ENT','Only CTS']">{{s}}</option>
                    </select>
                </div>
            </div>
<!--            <div class="col-sm-2">
                <div>
                    <select v-model="cts"  class="form-control">
                        <option v-for="s in ['Include CTS','Exclude CTS','Only CTS']">{{s}}</option>
                    </select>
                </div>
            </div>-->
            <div class="col-sm">
                <button type="button" @click="init(); " class="btn btn-success">Search</button>
            </div>
        </div>



        <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
            <h5>AFOHS <br>MONTHLY EMPLOYEE FOOD BILLS SHEET </h5>
        </div>
        <div style="text-align: center; color: black;">
            <p><strong>Year = {{this.year}}, Month = {{this.month}}, ID = {{this.employee_id}}, Name = {{this.customer}}, Company = {{this.pluck(this.company,'name')}}, Department = {{this.pluck(this.department,'name')}}, Sub-Department = {{this.pluck(this.subdepartment,'name')}}, Bill Details = {{this.ent}}</strong></p>

        </div>
        <div class="scrollclasstable1">

            <div>

                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">Employee</th>

                        <th class="wd-50p" v-for="n in
moment(end_date).diff(moment(start_date),'days')+1">
                            <span class="t1">{{moment(start_date).add(n-1,'days').format('ddd')}}</span>
                            <span class="t2">{{moment(start_date).add(n-1,'days').format('Do ')}}</span>

                        </th>
<th>Totals</th>
                    </tr>

                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-if="tr.grandd!=0" v-for="(tr,key) in

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
                        <td  >{{tr.name}} ({{tr.designation}})</td>
                        <td v-for="n in moment(end_date).diff(moment(start_date),'days')+1">
<!--v-if="(key==0) || employees[key-1].grandd!=tr.grandd"-->
                            <span v-for="(l,key) in  tr.foodbills.filter((a,k)=>{  return (moment(a.date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD'))})">
                                {{ (l.ddf).toLocaleString() }},

                             </span>

                                </td>
                            <td>{{ (tr.grandd).toLocaleString()}}</td>
                        </tr>

                    <tr v-if="tr.grandd!=0 && key==0" v-for="(tr,key) in

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
                        <td>GRAND TOTAL:</td>
                        <td v-for="n in moment(end_date).diff(moment(start_date),'days')+1">
                            <!--v-if="(key==0) || employees[key-1].grandd!=tr.grandd"-->
                            <span v-for="(l,key) in  tr.foodbills.filter((a,k)=>{  return (moment(a.date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD'))})">


                             </span>

                        </td>
                        <td> </td>
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
<style scoped>
table th{min-width:55px!important; font-size:11px;font-weight:bold;text-shadow:1px 1px 1px #000; text-align:center}
table td{font-size:11px; background:#fff!important}
table td span{
   border-radius:5px}

/*table td span:first-child{color:#fff; text-shadow:1px 1px 1px #000}*/
table td{
    text-align:center}

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
export default {
    name: "employeefoodbills",
    props: ['csrf'],
    data(){
        return{
            ent:'Include ENT and CTS',
            cts:'Include CTS',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            employees:[],
            employeesR:[],
            employeesM: [],
            year:2021,
            month:moment().startOf('month').format('MMMM'),
            start_date:moment().startOf('month').toString(),
            end_date:moment().endOf('month').toString(),
            mog:2,
            searchId:null,
            acftype:0,
            accTypes:[],
            detailsAll:[],
            cashrecsL:0,
            acc_permission:'',
            fkey:-1,
            ffkey:0,
            foodbills:[],
            customers:[],
            customer:'',

            companies:[],
            subdepartments:[],
            departments:[],
            department:[],
            subdepartment:[],
            company:[],
            employee_id:'',


        }
    },
    computed: {

    },

    methods:{
        diffCalc(start_date,end_date){
            // start time and end time
            console.log(start_date);
            var startTime = moment(start_date,'YYYY-MM-DD HH:mm:ss');
            var endTime = moment(end_date,'YYYY-MM-DD HH:mm:ss');

// calculate total duration>
            var duration = moment.duration(endTime.diff(startTime));

// duration in hours
            var hours = parseInt(duration.asHours());

// duration in minutes
            var minutes = parseInt(duration.asMinutes())%60;

            return (hours + ':'+ minutes+'');
        },
        onlyUnique(value, index, self) {

            return self.indexOf(value) === index;
        },
        calctime(arr){
            let total=[0,0];
            // console.log(arr);
            arr.forEach((x)=>{
                x=x.split(':');
              let  h=parseInt(x[0]);
               let m=parseInt(x[1]);
                let th=total[0];
                let tm=total[1];
                if(tm+m>60){
                    total[1]=(total[1]+m)%60
                    th=th+1;
                }
                else{
                    total[1]=total[1]+m;
                }
                total[0]=th+h;

            })
            if(total[0]>0 || total[1] >0)
            return (total[0].length==1?'0':'')+total[0]+':'+(total[1].length==1?'0':'')+total[1];
        },
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
        filterData(employees){
            let   x=employees;
           /*if(this.department!=0){
                x=x.filter((a)=>{return a.department==this.department});

            }*/

            if(this.employee_id){
                x=x.filter((a)=>{return a.id==this.employee_id});

            }

            if (this.searchId){
                x=x.filter((a)=>{return a.id==this.searchId});
            }

            if(this.department.length>0){
                x=x.filter((a)=>{return this.department.filter((m)=>{
                    return a.department==m.id;
                }).length>0});
            }

            if(this.company.length>0){
                x=x.filter((a)=>{return this.company.filter((m)=>{
                    return a.company==m.id;
                }).length>0});
            }

            if(this.subdepartment.length>0){
                x=x.filter((a)=>{return this.subdepartment.filter((m)=>{
                    return a.subdepartment==m.id;
                }).length>0});
            }

            else{
                x=x;
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

        init:function () {
            let params='';
            if(this.start_date) {
                params+='&start_date='+moment(this.start_date).format('YYYY-MM-DD')
            }  if(this.end_date) {
                params+='&end_date='+moment(this.end_date).format('YYYY-MM-DD')
            }
            if(this.ent){
                params+='&ent='+this.ent;
            }
            this.$http.get('/finance-and-management/reports/foodbills_init_vue?1=1'+params).then(result=>{
                let data=result.data;

                this.detailsAll=data.aa;
                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
                this.departments=data.departments;
                this.subdepartments=data.subdepartments;
                this.companies=data.companies;

                this.employees.forEach((x)=>{
                    if(x.foodbills){



                        x.grandd=this.sum(this.pluck(x.foodbills.filter((a)=>{a.ddf=(a.grand_total?a.grand_total:0);
                        return true}),'ddf'));



                        x.excludegrand=this.sum(this.pluck(x.foodbills.filter((a)=>{a.ddff=(a.grand_total && a.ent==0?a.grand_total:0) ;return true}),'ddff'));
                        x.onlygrand=this.sum(this.pluck(x.foodbills.filter((a)=>{a.ddfff=(a.grand_total && a.ent==1?a.grand_total:0) ;return true}),'ddfff'));
                    }

                    else{
                        x.grandd=0;
                        x.excludegrand=0;
                        x.onlygrand=0;
                    }
                })


            })
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
                    this.searchId=data.id;
                    this.customer = data.name;

                    this.alreadySearched=true;
                }
            });
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
                this.employees[k].p=e.target.max;
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
        employeesM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null;
            }

            if(this.customer.length>2 && !this.alreadySearched){
                this.customerdata();
            }
        },
        month:function(){
            this.start_date=moment(this.month+'/'+this.year,'MMMM/YYYY').startOf('month').toString();
                this.end_date=moment(this.month+'/'+this.year,'MMMM/YYYY').endOf('month').toString();
      this.init();
        },
        year:function (){

            this.start_date=moment(this.month+'/'+this.year,'MMMM/YYYY').startOf('month').toString();
                this.end_date=moment(this.month+'/'+this.year,'MMMM/YYYY').endOf('month').toString();
            this.init();


        }

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

