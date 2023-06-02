<template>
    <div>
        <vue-snotify></vue-snotify>
        <div v-if="showdetails">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>CHARGES DETAILS!</strong></h5>
                                    <button type="button" class="close" @click="showdetails=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span v-html="detailsdata?detailsdata.replaceAll(',','<br>'):''"></span>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-danger" @click="showdetails=false">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>


        <div class="row  hidden-print">
            <div class="col-lg">
                <div>

                   <select class="form-control" v-model="year">
                       <option>2020</option>
                       <option>2021</option>
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

             <div class="col-lg">
            <div>

                <select v-model="department"  class="form-control">
                    <option value="0">All</option>
                    <option v-for="dep in departments" :value="dep.desc">{{dep.desc}}</option>
                </select>
            </div>
        </div>


        </div>


        <br>
        <div class="scrollclasstable1">

            <div>

                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">S#</th>
                        <th class="wd-5p">ID</th>
                        <th class="wd-5p">Name</th>
                        <th class="wd-5p">Father Name</th>
                        <th class="wd-5p">CNIC</th>
                        <th class="wd-5p">Department</th>
                        <th class="wd-5p">Designation</th>
                        <th class="wd-5p">Date of joining</th>
                       <th class="wd-5p">Gross SALARY</th>
                        <th class="wd-5p">No. of DAYS/HOUR</th>
                        <th class="wd-5p">Net SALARY</th>
                        <th class="wd-5p">ALLOWANCE</th>
                        <th class="wd-5p">Incentive</th>
                        <th class="wd-5p">LOAN</th>
                        <th class="wd-5p">LOAN Deduction</th>
                        <th class="wd-5p">Advance Salary</th>
                        <th class="wd-5p">WHT Amount</th>
                        <th class="wd-5p">TOTAL SALARY</th>
                        <th class="wd-5p">EXTRA ALLOWANCE</th>

                        <th class="wd-5p">OVERTIME DAYS/HOUR</th>
                        <th class="wd-5p">TOTAL DAYS/HOUR</th>

                        <th class="wd-5p">ADJUSTED DAYS</th>
                        <th class="wd-5p">TOTALS</th>
                        <th class="wd-5p">PAYABLE SALARY</th>
                        <th class="wd-5p hidden-print">VOUCHER</th>
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
                        <td>{{key+1}}</td>
                        <td>{{tr.id}}
                       </td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.csalary}} / {{tr.csalary/tr.days}} / {{tr.csalary/tr.days/tr.hour}}</td>
                        <td>{{tr.advance}}</td>
                        <td v-html="tr.charges_details?tr.charges_details.replaceAll(',','<br>') + '<br> Total: '+tr.charges:''"></td>
                        <td><a href="#" @click.prevent="showdetails=true;detailsdata=tr.usage_details">{{tr.cr}}- {{tr.dr}} ={{tr.cr-tr.dr}}</a></td>

                        <td>{{tr.visits}} / {{tr.ctime}}</td>
                        <td>{{tr.overtimeDays}} / {{tr.overtime}}</td>
                        <td>{{tr.visits}} / {{tr.ctime}}</td>

                        <td><input type="number" v-model="tr.adjusted"> </td>
                        <td>{{tr.perhour}} x ({{tr.ctime}}+{{tr.adjusted}} x {{tr.hour}}) = {{Math.round(tr.perhour* (parseFloat(tr.ctime2)+parseFloat((tr.adjusted*tr.hour))) ) }}</td>
                        <td>
                           Total Visits: {{tr.visits}}<br>
                           Total hours: {{tr.ctime}}<br>
                        </td>
                        <td>
                            {{Math.round(tr.perhour*tr.ctime2 -(tr.cr>tr.charges?tr.cr-tr.charges:0)-(tr.advance?tr.advance:0))}}
                        </td>
                        <td class="hidden-print">
                            <input @click="pay_salary(tr.id)" :disabled="disableds"  :class="'btn-warning'" type="submit" name="save" class="btn" :value="'Generate'">
                        </td>

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
    name: "employeepayroll",
    props: ['csrf'],
    data(){
        return{
            page:1,showdetails:false,detailsdata:'',
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            employees:[],
            employeesR:[],
            employeesM: [],
            year:2020,
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
            disableds:false,
            departments:[],
            department:'0',
        }
    },
    computed: {
        totals() {
          let em=this.employees;


        }
    },
    methods:{
       /* console.log(
            this.employees.find(vall => vall.id === 1).name
        )*/
        pay_salary:function(idd){
            this.paythisid=idd;

            this.disableds=true;
            let data={
                employee_id:this.employees.find(vall => vall.id === idd).id,
                current_salary:this.employees.find(vall => vall.id === idd).csalary,
                hours:this.employees.find(vall => vall.id === idd).ctime,
                working_days:this.employees.find(vall => vall.id === idd).visits,
                overtime_days:this.employees.find(vall => vall.id === idd).overtimeDays,
                total_salary:Math.round(this.employees.find(vall => vall.id === idd).perhour* (parseFloat(this.employees.find(vall => vall.id === idd).ctime2)+parseFloat((this.employees.find(vall => vall.id === idd).adjusted*this.employees.find(vall => vall.id === idd).hour))) ) ,
                payable_salary:Math.round(this.employees.find(vall => vall.id === idd).perhour*this.employees.find(vall => vall.id === idd).ctime2 -(this.employees.find(vall => vall.id === idd).cr>this.employees.find(vall => vall.id === idd).charges?this.employees.find(vall => vall.id === idd).cr-this.employees.find(vall => vall.id === idd).charges:0)-(this.employees.find(vall => vall.id === idd).advance?this.employees.find(vall => vall.id === idd).advance:0)),
                pay_date:moment().format('DD/MM/YYYY'),
            };
            let url='/human-resource/employment/voucher/save';

            if(this.validation(data,['employee_id','current_salary','hours', 'working_days','overtime_days'])==0){
                this.$http.post(url,data).then(result=> {
                    this.init();
                  /*  window.location.href = "/human-resource/employment/payroll-vue";*/
                }).catch(error=> {
                    this.disableds=false;
                    this.$snotify.error('Something went wrong !');
                });
            }
            else{
                this.disableds=false;

            }
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
           if(this.department!=0){
                x=x.filter((a)=>{return a.department==this.department});

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
            this.$http.get('/human-resource/employment/payroll_init_vue?1=1'+params).then(result=>{
                let data=result.data;

                this.detailsAll=data.aa;
                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
                this.departments=data.departments;

            })
        },

        customerdata(){
            let v = this.mog;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;
                if(v==0){
                    data.filter((a)=>{
                        let fname=a.first_name?a.first_name+' ':'';
                        let mname=a.middle_name?a.middle_name+' ':'';
                        let lname=a.applicant_name?a.applicant_name:'';
                        let fullname=fname+mname+lname;

                        if(a.active==1){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Active' + ')'
                        }
                        else if(a.active==2){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Expired' + ')'
                        }
                        else if(a.active==3){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Suspended' + ')'
                        }
                        else if(a.active==4){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Terminated' + ')'
                        }
                        else if(a.active==5){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Absent' + ')'
                        }
                        else if(a.active==6){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Cancelled' + ')'
                        }
                        else if(a.active==7){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Not Assigned' + ')'
                        }
                    })
                }
                else if(v==1){
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
                }
                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = this.mog;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.families=[];
                    this.searchId=data.id;
                    if (v == 0) {
                        this.mem_id = data.mem_no;
                        this.mem_id_ = data.id;

                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;
                        // console.log(data);
                        this.families=data.family;
                        this.ledger_amount=data.balance;
                        //this.employees=data.employees;
                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;
                        this.ledger_amount=data.balance;
                        //this.employees=data.employees;
                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
                        this.ledger_amount=data.balance;
                        //this.employees=data.employees;

                    }

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

