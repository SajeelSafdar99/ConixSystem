


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div class="col-xl-12 ">
            <div class="desktop-screen-design">

                <div  class="row ">
                    <label class="col-sm-3 form-control-label">
                        Serial #:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <input id="serial_no" class="form-control input-height" type="number" autocomplete="off" readonly="" v-model="serial_no" name="serial_no" style="background-color: #c1c1c1">

                    </div>
                </div>
                <div  class="row mg-t-10">
                    <label class="col-sm-3 form-control-label">
                        Issue Date:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <template v-if="!this.id">
                            <input type="text" v-model="issue_date" value="" placeholder="dd/mm/yyyy" name="issue_date" id="issue_date" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                        </template>
                        <template v-else>
                            <input type="text" :value="this.issue_date | moment('DD/MM/YYYY')" placeholder="dd/mm/yyyy" name="issue_date" id="issue_date" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                        </template>
                    </div>
                </div>

                <div class="row mg-t-10">
                    <label class="col-sm-3 form-control-label">
                        Department:
                        <span class="tx-danger">
                                *
                            </span>
                    </label><div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select id="department" v-model="department" name="department" class="form-control " >
                        <option label="Choose Option" value="0"></option>
                        <option :value="department.id" v-for="department in departments">
                            {{ department.desc }}
                        </option>

                    </select>  </div>
                </div>


                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Description of Problems:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <textarea rows="15" type="text" class="form-control" id="description" v-model="description" placeholder="Enter Details" autocomplete="off"></textarea>
                            </div>
                        </div>


                        <br><br><br>

                        <!--// BUTTONS-->
                                 <input @click="save(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">


                                <a href="/maintenance-management/work-order-sheet-vue"><button class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br><br><br>

        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "workordersheet",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              serial_no:'',
              issue_date:'',
              departments:[],
              department:'0',
              description:'',
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

                this.disableds=true;

                let data={
                    serial_no:this.serial_no,
                    issue_date:this.issue_date,
                    department:this.department,
                    description:this.description,
                };
                let url='/maintenance-management/work-order-sheet/work-order-sheet-aeu/save';
                if(m){
                    url='/maintenance-management/work-order-sheet/work-order-sheet-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['serial_no','issue_date', 'department', 'description'])==0){
    this.$http.post(url,data).then(result=> {
            window.location.href = "/maintenance-management/work-order-sheet-vue";
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
                this.$http.get('/maintenance-management/work-order-sheet/work-order-sheet-ini'+r).then(result=>{
                    let data =result.data;
                    if(m) {
                        this.serial_no=data.serial_no;
                        this.issue_date=data.issue_date;
                        this.department=data.department;
                        this.description=data.description;
                        this.id=data.id;

                    }
                    else{
                        this.serial_no=data.increment_number;
                        this.issue_date=moment().format('DD/MM/YYYY');
                        this.department=0;
                        this.description='';
                        this.id='';
                    }
                    this.departments=data.departments;
                    this.disableds=false;

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
