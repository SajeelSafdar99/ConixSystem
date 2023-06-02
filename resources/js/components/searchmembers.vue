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
            <p style="color: black;">Member Barcode</p>
            <input value="" class="form-control "  size="20" type="text"
                   id="mem_barcode" autocomplete="off" v-model="mem_barcode"
                   name="mem_barcode" placeholder="Search by Barcode No.">
        </div>
        <div class="col-lg">
            <p style="color: black;">Family Member Barcode</p>
                <input value="" class="form-control "  size="20" type="text"
                       id="barcode" autocomplete="off" v-model="barcode"
                       name="barcode" placeholder="Search by Barcode No.">
        </div>



        <div class="col-lg">
            <p style="color: black;">Family Member</p>
            <div class="form-group"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">


                <input  v-model="fcustomer" name="fcustomer" id="fcustomer" value="" class="typeahead form-control" autocomplete="off" type="text"  placeholder="Search By Name...">

                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="fcustomers.length>0 && fcustomer!=''" >
                    <li class="fbb" :class="'ccs'+key"  @click="fcustomerdatavalue(c.id)"  v-on:keyup.enter="fcustomerdatavalue(c.id)" v-for="(c,key) in fcustomers">
                        <a href="javascript:void(0)">   {{c.name}}</a>
                    </li>

                </ul>


            </div>


        </div>

        <div class="col-lg">
            <p style="color: black;">Member</p>
            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">


                <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search By Member...">

                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >
                    <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                        <a href="javascript:void(0)" v-html="c.name"></a>
                    </li>
                </ul>

            </div>

        </div>


        <div class="col-lg">
            <p style="color: black;">CNIC</p>
            <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                   id="cnic" v-model="cnic"
                   name="cnic" placeholder="Search by CNIC">
        </div>
        <div class="col-lg">
            <p style="color: black;">Contact (Primary)</p>
            <input value="" autocomplete="off" class="form-control "  size="20" type="number"
                   id="contact" v-model="contact"
                   name="contact" placeholder="Search by Contact">
        </div>

        <div class="col-lg">
            <p style="color: black;">Car Number</p>
            <input value="" autocomplete="off" class="form-control "  size="20" type="number"
                   id="carno" v-model="carno"
                   name="carno" placeholder="Search by Car No.">
        </div>

        <div class="col-lg">
            <div>
                <p style="color: black;">&nbsp</p>
                <button type="button" class="btn btn-success" v-on:click="init">Search</button>

            </div>
        </div>

    </div>
    <br>


    <div class=" emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <template v-if="!this.family">

                       <template v-if="membershipdata.profilePic">
                           <img :src="'/'+membershipdata.profilePic.url" alt=""/>
                       </template>
                       <template v-else>
                         <img src="https://image.flaticon.com/icons/png/512/149/149071.png" alt=""/>
                       </template>


                        </template>
                        <template v-else>
                            <template v-if="family.familymemberPic">
                                <img :src="'/'+family.familymemberPic.url" alt=""/>
                            </template>
                            <template v-else>
                            <img src="https://image.flaticon.com/icons/png/512/149/149071.png" alt=""/>
                            </template>

                        </template>


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <template v-if="!this.family">
                        <h5 style="text-transform: uppercase;">
                            {{membershipdata.title}} {{membershipdata.first_name}} {{membershipdata.middle_name}} {{membershipdata.applicant_name}} ({{membershipdata.active}})
                        </h5>
                        <h6>
                            Membership No: {{membershipdata.mem_no}}
                        </h6>
                        <p class="proile-rating">Membership expiry: {{membershipdata.card_exp}}</p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true">Membership Information</a>
                            </li>

                        </ul>
                        </template>
                        <template v-else>

                        <h5>
                            {{family.title}} {{family.first_name}} {{family.middle_name}} {{family.name}}
                        </h5>
                        <h6>
                            Membership No: {{family.sup_card_no}}
                        </h6>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true">Membership Information</a>
                            </li>

                        </ul>

                        </template>
                    </div>
                </div>
                <div class="col-md-2">
                    <template v-if="!this.family">
                    <a :href="'/members-access/search-members/' + 'member' + '/' + this.membershipdata.id" class="btn btn-primary">Check In</a>
                   <hr>
                    <span class="">Last check in:<br> {{visits?visits.created_at.format('F jS Y | h:i A'):'never'}}</span>
                    <hr>
                    <template v-if="this.countofvisits>1">
                    <a href="#" data-toggle="collapse" data-target="#history"><i class="fa fa-arrow-circle-down"></i> See History</a>
                    <ul class="list-unstyled collapse" id="history" v-for="v in membervisits">
                        <li>
                            {{v.created_at.format('F jS Y | h:i A')}}
                        </li>
                    </ul>
                    </template>



                    </template>
                    <template v-else>


                    <a :href="'/members-access/search-members/' + 'family' + '/' + this.family.id" class="btn btn-primary">Check In</a>
                    <hr>
                    <span class="">Last check in:<br> {{fvisits?fvisits.created_at.format('F jS Y | h:i A'):'never'}}</span>
                    <hr>
                        <template v-if="this.countoffvisits>1">
                    <a href="#" data-toggle="collapse" data-target="#history"><i class="fa fa-arrow-circle-down"></i> See History</a>
                            <ul class="list-unstyled collapse" id="history" v-for="v in familyvisits">
                                <li>
                                    {{v.created_at.format('F jS Y | h:i A')}}
                                </li>
                            </ul>
                        </template>


                    </template>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <h2>Member Subscriptions</h2>
                        <ul class="list-unstyled" v-for="s in sub">
                            <template v-if="s">
                            <li style="color:#000;font-size:18px">
                                <template v-if="s.ac==1"> <i class="fa fa-check text-success fa-2x"></i></template>
                                <template v-else> <i class="fa fa-times text-danger fa-2x"></i></template> {{s.name}}
                            </li>
                            </template>
                            <template v-else>
                            <li style="color:#000;font-size:18px">No subscription found</li>
                            </template>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <template v-if="!this.family">
                                <template v-if="membershipdata.personal_email">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{membershipdata.personal_email}}</p>
                                </div>
                            </div>
                                </template>

                                <template v-if="membershipdata.mob_a">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Contact</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{membershipdata.mob_a}}</p>
                                </div>
                            </div> <div class="row">
                            <div class="col-md-6">
                                <label>Barcode</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{membershipdata.mem_barcode}}</p>
                            </div>
                        </div>
                                </template>


                                <template v-if="membershipdata.date_of_birth">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date of Birth</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{membershipdata.date_of_birth}}</p>
                                </div>
                            </div>
                                </template>


                            </template>
                            <template v-else>


                                <template v-if="family.relationship_name">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Relationship</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{family.relationship_name.desc}}</p>
                                </div>
                            </div> <div class="row">
                            <div class="col-md-6">
                                <label>Maritial Status:</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{family.maritial_status}}</p>
                            </div>
                        </div>
                                </template>


                                <template v-if="family.sup_barcode">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Bar Code:</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{family.sub_barcode}}</p>
                                </div>
                            </div>
                                </template>

                            </template>

                           <template v-if="this.membershipdata.family">
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>
                                        Family
                                    </h5>
                                    <div class="row" >
                                    <template v-for="f in families">
                                        <div class="col-sm-6">
                                            <div class="card" style="    background: #49a2fb;">

                                                <div class="">
                                                    <table class="table table-striped">

                                                        <template v-if="this.membershipdata.profilePic">
                                                        <img src="" alt=""/>

                                                        <tr>
                                                            <td colspan="1" class="text-center">
                                                                <img  :src="'/'+membershipdata.profilePic.url" style="height: 150px;    width: 100px;" class="img-responsive">
                                                                <h5>{{membershipdata.title}} {{membershipdata.first_name}} {{membershipdata.middle_name}} {{membershipdata.applicant_name}}</h5>

                                                            </td>
                                                            <td>
                                                                <table class="table table-striped">
                                                                    <tr>
                                                                        <td>Membership No: </td>
                                                                        <td>{{membershipdata.mem_no}}</td>
                                                                    </tr>

                                                                    <template v-if="membershipdata.mob_a">
                                                                    <tr>
                                                                        <td>Contact: </td>
                                                                        <td>{{membershipdata.mob_a}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <template v-if="membershipdata.mem_barcode">
                                                                    <tr>
                                                                        <td>Bar Code: </td>
                                                                        <td>{{membershipdata.mem_barcode}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <template v-if="membershipdata.date_of_birth">
                                                                    <tr>
                                                                        <td>Date of Birth: </td>
                                                                        <td>{{membershipdata.date_of_birth}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <tr>

                                                                        <td colspan="2">


                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>  <span class="">Last check in: <br>{{visits?visits.created_at.format('M jS Y | h:i A'):'never'}}</span><br>
                                                                            <template v-if="this.countofvisits>1">
                                                                            <a href="#" data-toggle="collapse" :data-target="'history'+membershipdata.id"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                            <ul class="list-unstyled collapse" :id="'history'+membershipdata.id" v-for="v in membervisits">
                                                                                <li>
                                                                                    {{v.created_at.format('F jS Y | h:i A')}}
                                                                                </li>
                                                                            </ul>

                                                                            </template>
                                                                        </td>
                                                                        <td><a :href="'/members-access/search-members/' + 'member' + '/' + this.membershipdata.id" class="btn btn-primary">Check In</a>


                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>

                                                        </tr>
                                                        </template>
                                                        <template v-else>
                                                            <tr>
                                                                <td colspan="1" class="text-center">
                                                                    <img src="https://image.flaticon.com/icons/png/512/149/149071.png" height="150px" width="150px" class="img-responsive">
                                                                    <h5>{{f.name}}</h5>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped">
                                                                        <tr>
                                                                            <td>Membership No: </td>
                                                                            <td>{{f.sup_card_no}}</td>
                                                                        </tr>
                                                                        <template v-if="f.relationship_name">
                                                                            <tr>
                                                                                <td>Relationship: </td>
                                                                                <td>{{f.relationship_name.desc}}</td>
                                                                            </tr>
                                                                        </template>
                                                                        <template v-if="f.maritial_status">
                                                                            <tr>
                                                                                <td>Maritial Status: </td>
                                                                                <td>{{f.maritial_status}}</td>
                                                                            </tr>
                                                                        </template>
                                                               <!--         <tr>
                                                                            <td>  <span class="">Last check in:<br> {{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                                @if(count($f->visits)>1)
                                                                                <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                                <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                                    @foreach($f->visits->sortByDesc('id') as $v)
                                                                                    @if ($loop->first) @continue @endif
                                                                                    <li>
                                                                                        {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                    </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                                @endif
                                                                            </td>
                                                                            <td><a :href="'/members-access/search-members/' + 'family' + '/' + f.id" class="btn btn-primary">Checkin</a>


                                                                            </td>
                                                                        </tr>-->
                                                                    </table>

                                                                </td>

                                                            </tr>
                                                        </template>



                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                   <!-- write else here-->
                                        <div class="col-sm-6">
                                            <div class="card">


                                                    <table class="table table-striped">

                                                       <template v-if="f.familymemberPic">

                                                        <tr>
                                                            <td colspan="1" class="text-center">
                                                                <img  :src="'/'+f.familymemberPic.url" style="height: 150px;    width: 100px;" class="img-responsive">
                                                                <h5>{{f.title}} {{f.first_name}} {{f.middle_name}} {{f.name}}</h5>

                                                            </td>
                                                            <td>
                                                                <table class="table table-striped">
                                                                    <tr>
                                                                        <td>Membership No: </td>
                                                                        <td>{{f.sup_card_no}}</td>
                                                                    </tr>
                                                                    <template v-if="f.relationship_name">
                                                                    <tr>
                                                                        <td>Relationship: </td>
                                                                        <td>{{f.relationship_name.desc}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <template v-if="f.maritial_status">
                                                                    <tr>
                                                                        <td>Maritial Status: </td>
                                                                        <td>{{f.maritial_status}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <template v-if="f.sup_barcode">
                                                                    <tr>
                                                                        <td>Bar Code: </td>
                                                                        <td>{{f.sup_barcode}}</td>
                                                                    </tr>
                                                                    </template>
                                                                    <tr>

                                                                        <td colspan="2">

                                                                          <!--  @foreach(
                                                                            !empty($familySubscriptions)?( $familySubscriptions['family']==$f->id?$familySubscriptions['subs']:[]):[]
                                                                            as
                                                                            $subscription)

                                                                            <p > <i class="fa fa-check"></i> &nbsp; {{($subscription['subscription']['desc'])}} <small>(Valid till {{formatDateToShow($subscription['end_date'])}})</small></p>
                                                                            @endforeach-->
                                                                        </td>
                                                                    </tr>
                                                                   <!-- <tr>
                                                                        <td>  <span class="">Last check in: <br>{{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                            @if(count($f->visits)>1)
                                                                            <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                            <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                                @foreach($f->visits->sortByDesc('id') as $v)
                                                                                @if ($loop->first) @continue @endif
                                                                                <li>
                                                                                    {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            @endif
                                                                        </td>
                                                                        <td><a :href="'/members-access/search-members/' + 'family' + '/' + f.id" class="btn btn-primary">Checkin</a>


                                                                        </td>
                                                                    </tr>-->
                                                                </table>
                                                            </td>

                                                        </tr>
                                                    </template>
                                                    <template v-else>
                                                    <tr>
                                                        <td colspan="1" class="text-center">
                                                            <img src="https://image.flaticon.com/icons/png/512/149/149071.png" height="150px" width="150px" class="img-responsive">
                                                            <h5>{{f.name}}</h5>
                                                        </td>
                                                        <td>
                                                            <table class="table table-striped">
                                                                <tr>
                                                                    <td>Membership No: </td>
                                                                    <td>{{f.sup_card_no}}</td>
                                                                </tr>
                                                                <template v-if="f.relationship_name">
                                                                <tr>
                                                                    <td>Relationship: </td>
                                                                    <td>{{f.relationship_name.desc}}</td>
                                                                </tr>
                                                                </template>
                                                                <template v-if="f.maritial_status">
                                                                <tr>
                                                                    <td>Maritial Status: </td>
                                                                    <td>{{f.maritial_status}}</td>
                                                                </tr>
                                                                </template>
                                                             <!--   <tr>
                                                                    <td>  <span class="">Last check in:<br> {{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                        @if(count($f->visits)>1)
                                                                        <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                        <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                            @foreach($f->visits->sortByDesc('id') as $v)
                                                                            @if ($loop->first) @continue @endif
                                                                            <li>
                                                                                {{$v->created_at->format('F jS Y | h:i A')}}
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                        @endif
                                                                    </td>
                                                                    <td><a :href="'/members-access/search-members/' + 'family' + '/' + f.id" class="btn btn-primary">Checkin</a>


                                                                    </td>
                                                                </tr>-->
                                                            </table>

                                                        </td>

                                                    </tr>
                                                    </template>

                                                    </table>

                                            </div>
                                        </div>

                                    </template>
                                    </div>
                                </div>
                            </div>
                           </template>

                        </div>

                    </div>
                </div>
            </div>
        </form>
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
        name: "searchmembers",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                memberships:[],
                membershipsR:[],
                membershipsM: [],
                mem_barcode:'',
                barcode:'',
                memberid:'',
                cnic:'',
                contact:'',
                carno:'',
                customers:[],
                fcustomers:[],
                customer:'',
                fcustomer:'',
                mog:2,
                searchId:null,
                famsearchId:null,
                fkey:-1,
                ffkey:0,

                membershipdata:'',
                familySubscriptions:'',
                memberSubscriptions:'',
                sub:[],
                family:'',
                visits:'',
                countofvisits:'',
                membervisits:[],

                fvisits:'',
                countoffvisits:'',
                familyvisits:[],
                families:[],
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




            },udf2(event){

                if(event==0){
                    if(this.ffkey!=this.fcustomers.length-1){

                        this.ffkey=this.ffkey+1
                    }
                    $('.ccs'+this.ffkey +' a').focus();

                    // $('.fba'+this.ffkey).focus();
                    // event.preventDefault()
                }if(event==1){

                    if(this.ffkey!=0){

                        this.ffkey=this.ffkey-1
                    }
                    $('.ccs'+this.ffkey+' a').focus();

                    // event.preventDefault()
                }




            },
            filterData(memberships){
             let   x=memberships;


                if(this.status){

                    if(this.status=='Active')
                    {
                        x=x.filter((a)=>{return a.status==1});

                    }
                    else if(this.status=='In-Active')
                        {
                        x=x.filter((a)=>{return a.status==0});

                    }
                    else{
                        x=x;
                    }
                }

                if(this.card_status.length>0){
                    x=x.filter((a)=>{return this.card_status.filter((m)=>{
                        return a.card_status==m.name;
                    }).length>0});

                }

                if(this.gender.length>0){
                    x=x.filter((a)=>{return this.gender.filter((m)=>{
                        return a.gender==m.name;
                    }).length>0});

                }

                if(this.barcode){

                    x=x.filter((a)=>{
                        return a.sup_barcode?a.sup_barcode.split(',').indexOf(this.barcode.toString())!=-1:false
                    });

                }

                if(this.memberid){
                    x=x.filter((a)=>{return a.id==this.memberid});

                }
                if(this.cnic){
                    x=x.filter((a)=>{return a.cnic==this.cnic});

                }
                if(this.contact){
                    x=x.filter((a)=>{return a.contact==this.contact});

                }

                if (this.searchId){
                    x=x.filter((a)=>{return a.member_id==this.searchId});
                }


                if (this.famsearchId){
                    x=x.filter((a)=>{return a.id==this.famsearchId});
                }

                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(memberships){
                // console.log(123);
                this.membershipsM=memberships;
              return  memberships.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {


                    this.$http.get('/members-access/search-members/search_members_init_vue?barcode='+this.barcode+'&mem_barcode='+this.mem_barcode+'&cnic='+this.cnic+'&contact='+this.contact+'&carno='+this.carno+'&mocid='+this.searchId+'&fammocid='+this.famsearchId).then(result=>{
                        let data=result.data;

                        this.membershipdata=data.membershipdata;
                        this.family=data.family;
                        this.familySubscriptions=data.familySubscriptions;
                        this.memberSubscriptions=data.memberSubscriptions;
                        this.sub=data.sub;
                        this.visits=data.visits;
                        this.membervisits=data.membervisits;
                        this.countofvisits=data.countofvisits;
                        this.fvisits=data.fvisits;
                        this.familyvisits=data.familyvisits;
                        this.countoffvisits=data.countoffvisits;
                        this.families=data.families;
                    })


            },

            customerdata(){
                let v = 0;
                this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                    let data =result.data;
                    if(v==0){
                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.applicant_name?a.applicant_name:'';
                            let fullname=fname+mname+lname;

                            a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                            a.color=a.mem_status.color
                        })
                    }

                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = 0;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){

                        this.searchId=data.id;

                        if (v == 0) {
                            this.mem_id = data.mem_no;
                            this.mem_id_ = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;

                        }


                        this.alreadySearched=true;
                    }
                });
            },
            fcustomerdata(){
                this.$http.post('/search/famcustomerdatalike',{customerid:this.fcustomer}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.name?a.name:'';
                            let fullname=fname+mname+lname;

                            if(a.status==1){
                                a.name=fullname + ':' + a.sup_card_no + ' ' + '(' + 'Active' + ')'
                            }
                            else if(a.status==2){
                                a.name=fullname + ':' + a.sup_card_no + ' ' + '(' + 'In-Active' + ')'
                            }

                        })

                    if(data){

                        this.fcustomers=data;

                    }
                });

            },
            fcustomerdatavalue(val,m){
                this.fcustomers=[];

                this.$http.post('/search/famcustomerdata?inv=1',{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){
                        this.famsearchId=data.id;

                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.name?data.name:'';

                            this.fcustomer = fname+mname+lname;
                            this.guest_contact = data.contact;


                        this.falreadySearched=true;
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
            membershipsM:function(){
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
            fcustomer:function(){
                if(this.fcustomer.length==0){
                    this.falreadySearched=false;
                    this.famsearchId=null;
                }

                if(this.fcustomer.length>2 && !this.falreadySearched){
                    this.fcustomerdata();
                }
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

