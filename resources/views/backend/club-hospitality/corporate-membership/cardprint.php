<?php

//dd($mem->toArray())
?>
<html>
<head>
<style>
    @font-face {
        font-family: myraid;
        src: url('/myraidpro.woff');
    }
    @font-face {
        font-family: impact;
        src: url('/impact.ttf');
    }

    .card-container .card{
        height:440px;
        width:700px;
        position:relative;

    }
    .card-container{
        height:440px;
        width:700px;
        margin:0 auto;
    }
    .logo{
        position:absolute;
        left:250px;
        top:33px;
    }
    .card-image{
        position:absolute;
        top: 129px;
        left: 41px;
    }
    .card-image img{
        height:163px;
        border: 2px solid #0e5393;
        width:142px;}
    .name{
        font-family:myraid;
        font-size:20px;
        margin-top:7px;
        font-weight:bold;
        letter-spacing: 1px;
    }
    .mem_no{
        position: absolute;

        top: 243px;
        left: 317px;
    }
    /*top: 275px;
        left: 329px;*/
    .mem_no h3{
        font-size: 24px;
        font-family: myraid;
        font-weight: bold;}
    .mem_no h3 span{
        display: block;
        text-align: center;
        margin-top: 4px;
        font-family: impact;
        font-weight: normal;
        letter-spacing: 1px;
    }
    .barcode {
        position: absolute;
        right: 38px;
        top: 189px;

    }
    .barcode img {
        height: 102px;
        width: 102px;
    }
    .valid span:nth-child(3) {
        font-size: 30px;
        right: -80px;
        top: 9px;
        position: absolute;
    }
    .valid span:nth-child(2) {
        position: absolute;
        top: -20px;
        font-size: 14px;
        right: -82px;
    }
    .valid {
        right: 129px;
        bottom: 82px;
        position: absolute;
        font-family: impact;
        font-size: 20px;
        line-height: 0.9;
    }
    .footer{
        position: absolute;
        bottom: 0;
        height: 76px;
        background: #055394;
        width: 100%;
        font-size: 20px;
        color: #fff;
        opacity: 1;
        font-family: myraid;
        text-transform: uppercase;
        text-align: center;
        /* padding-top: 20px; */
        line-height: 2.2;
        font-size: 25px;
        letter-spacing: 7px;
        font-weight: bold;}
    </style>
    <script src="//html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
    <body>
<div class="card-container" >
<div class="card">
    <div class="logo">
        <img src="<?php echo url('/logocard.png')?>">


    </div>
    <div class="card-image">
        <img src="<?php echo url($mem->profilePic->url)?>">
   <div class="name"><?php echo " " . wordwrap($mem->title.' '.$mem->first_name.' '.$mem->middle_name.' '.$mem->applicant_name, 25, '<br>') . '<br>';?></div>
    </div>
    <div class="mem_no">
        <h3><span><?php echo corporatecompanyname($mem->corporate_company)?></span> Membership No <span><?php echo $mem->mem_no?></span></h3>
    </div>
    <div class="barcode">
        <img src="<?php echo url('/qrcard.png')?>">
    </div>
    <div class="valid">
        <span>VALID<br>THRU</span>
        <span>MONTH/YEAR</span>
        <span><?php echo date('m/y',strtotime($mem->card_exp))?></span>
    </div>
    <div class="footer">
        Primary Member
    </div>

</div>

    <button style="margin: 0 auto;
    display: block;
    margin-top: 20px;
    font-size: 20px;" type="button" onclick="download()">Generate</button>
</div>
<script>
    function download(){
        html2canvas(document.querySelector(".card")).then(canvas => {
          //  document.body.appendChild(canvas);


            saveAs(canvas.toDataURL("image/png"),'<?php echo $mem->mem_no?>')
        });
    }
    function saveAs(uri, filename) {
        var link = document.createElement('a');
        if (typeof link.download === 'string') {
            link.href = uri;
            link.download = filename;

            //Firefox requires the link to be in the body
            document.body.appendChild(link);

            //simulate click
            link.click();

            //remove the link when done
            document.body.removeChild(link);
        } else {
            window.open(uri);
        }
    }
</script>
</body>
</html>
