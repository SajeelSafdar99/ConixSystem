<template>
    <div>
        <vue-snotify></vue-snotify>



        <div class="row  hidden-print">
            <div class="col-lg">
                <div>

                   <select class="form-control" v-model="year">
                       <option>2020</option>
                       <option>2021</option>
                       <option>2022</option>
                       <option>2023</option>
                   </select>
                </div>
            </div>
            <div class="col-lg">
                <div>

                    <select class="form-control" v-model="month">
                        <option v-for="n in 12">{{moment(n, 'M').format('MMMM')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-5">
            </div>



        </div>
<br>


        <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
            <h5>AFOHS <br>ROOM BOOKING CALENDAR </h5>

        </div>
        <div style="text-align: center; color: black;">
            <p><strong>Year = {{this.year}}, Month = {{this.month}}</strong></p>

        </div>
        <div class="scrollclasstable1">

            <div>

                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">ROOMS</th>
                        <th class="" v-for="n in
moment(end_date).diff(moment(start_date),'days')+1">
                            <span class="t1">{{moment(start_date).add(n-1,'days').format('ddd')}}</span>
                            <span class="t2">{{moment(start_date).add(n-1,'days').format('Do ')}}</span>

                        </th>

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
                        <td>Room No. {{tr.room_no}}</td>
                        <template v-for="n in moment(end_date).diff(moment(start_date),'days')+1">
                            <template v-for="(l,key) in  tr.visits.filter((a,k)=>{  return (moment(a.check_in_date).format('YYYY-MM-DD')<=moment(start_date).add(n-1,'days').format('YYYY-MM-DD') && moment(a.check_out_date).format('YYYY-MM-DD')>=moment(start_date).add(n-1,'days').format('YYYY-MM-DD'))})">


                                <template v-if="l.check_out_time!=null">

                              <td  style="background-color: lightskyblue !important"  :title="'Booked By: '+l.first_name+' '+l.last_name+'\n'+'Contact: '+l.moc_mob+'\n'+'Status: Checked Out'">
                                  <template v-if=" moment(l.check_in_date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD') ">
                                      <b>#{{l.booking_no}}: {{l.first_name}} {{l.last_name}}</b>
                                  </template>
                            </td>
                                </template>
                                <template  v-else-if="l.check_in_time!=null">
                                    <td  style="background-color: yellow !important"  :title="'Booked By: '+l.first_name+' '+l.last_name+'\n'+'Contact: '+l.moc_mob+'\n'+'Status: Checked In At '+l.check_in_time">
                                        <template v-if=" moment(l.check_in_date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD') ">
                                            <b>#{{l.booking_no}}: {{l.first_name}} {{l.last_name}}</b> <a target="_blank" :href="'/room-management/room-check-out/room-check-out-aeu/' + l.id"><button class="btn-sm btn btn-outline-success active  " title="Check-In">Check Out</button></a>
                                        </template>
                                    </td>
                                </template>
                                <template  v-else-if="l.advance_paid!=null">
                                    <td  style="background-color: forestgreen !important"  :title="'Booked By: '+l.first_name+' '+l.last_name+'\n'+'Contact: '+l.moc_mob+'\n'+'Status: Waiting for Check In'">
                                        <template v-if=" moment(l.check_in_date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD') ">
                                            <b>#{{l.booking_no}}: {{l.first_name}} {{l.last_name}}</b>  <a target="_blank" :href="'/room-management/room-check-in/room-check-in-aeu/' + l.id"><button class="btn-sm btn btn-outline-primary active  " title="Check-In">Check In</button></a>
                                        </template>
                                    </td>
                                </template>
                                <template  v-else>
                                    <td  style="background-color: #b8b7f7 !important"  :title="'Booked By: '+l.first_name+' '+l.last_name+'\n'+'Contact: '+l.moc_mob+'\n'+'Status: Waiting for Check In'">
                                        <template v-if=" moment(l.check_in_date).format('YYYY-MM-DD')==moment(start_date).add(n-1,'days').format('YYYY-MM-DD') ">
                                            <b>#{{l.booking_no}}: {{l.first_name}} {{l.last_name}}</b>  <a target="_blank" :href="'/room-management/room-check-in/room-check-in-aeu/' + l.id"><button class="btn-sm btn btn-outline-primary active  " title="Check-In">Check In</button></a>
                                        </template>
                                    </td>
                                </template>


                            </template>
                        </template>

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
table td span:first-child{color: #000000;}
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
    name: "roomcalendar",
    props: ['csrf'],
    data(){
        return{
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
            visits:[],
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
        totals() {
          let em=this.employees;


        }
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
            this.$http.get('/room-management/calender/calendar_init_vue?1=1'+params).then(result=>{
                let data=result.data;

                this.detailsAll=data.aa;
                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
                this.departments=data.departments;
                this.subdepartments=data.subdepartments;
                this.companies=data.companies;

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

