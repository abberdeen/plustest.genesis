<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();} ?>
<html><head>
    <title>Мактуб | <?=APP_BRAND?></title>
    <?php       
    include app::templateLink("page/_meta");
    include app::templateLink("page/_links");
    ?>
    <style>
        .frm-control{
            font-size: 0.9rem;
            font-family:  Roboto,"Helvetica Neue",Arial,sans-serif;
            width: 100%;
        }
        .frm-control-sm{
            height: 1.3rem;
        }
        .frm-control-label{
            padding-top: 0;
        }
    </style>
</head>
<body>
<?php  include app::templateLink("page/navbar");?>
<div class="container">
    <form name="pgLetter" action="<?=$router->generate('cpl_shared_submit')?>" method="post" autocomplete="off" >
        <h3>Шикоят/Пешниҳод</h3>
        <hr/>
        <div class="form-group row">
            <div class="col-md-12">
                Ин саҳифа барои фиристодани мактуб ба маъмурияти <?=kb::a('tg','системаи имтиҳонот','системаи имтиҳоноти')?> <?=kb::a('tg','донишкада')?>.
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <label class="col-md-3 col-form-label $$ frm-control-label" for="">
                <span class="text-primary">Намуди мактуб</span>  <br/>
                <span class="small text-muted">Намуди мактубро интихоб намоед.</span>
            </label>
            <div class="col-md-9">
                <div class="form-check" style="margin: 0;">
                    <label class="custom-control" style="margin: 0 10px 0 0;">
                        <input id="pgCplComplain" name="pgCplLetterType" type="radio"
                               class="custom-control-input" value="complain">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Шикоят</span>
                    </label>
                    <label class="custom-control" style="margin: 0 5px 0 0;">
                        <input id="pgCplProposal" name="pgCplLetterType" type="radio"
                               class="custom-control-input" value="proposal">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Пешниҳод</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label $$ frm-control-label" for="pgCplTheme">
                <span class="text-primary">Мавзӯъ</span>
                <br/>
                <span class="small text-muted">Мавзӯъи заруриро интихоб намоед.</span>
            </label>
            <div class="col-md-9">
                <select name="pgCplTheme" id="pgCplTheme" class="frm-control frm-control-sm">
                    <option value=""></option>
                    <option value="a">Option A</option>
                    <option value="b">Option B</option>
                    <option value="c">Option C</option>
                    <option value="d">Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label $$ frm-control-label" for="pgCplCaption">
                <span class="text-primary">Сарлавҳа</span>
                <br/>
                <span class="small text-muted">Мактуб метавонад номи худро дошта бошад.</span>
            </label>
            <div class="col-md-9">
                <input name="pgCplCaption" id="pgCplCaption" type="text" class="frm-control frm-control-sm" onkeyup="pgOnchange(this.id,this.value);"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label $$ frm-control-label" for="pgCplContent">
                <span class="text-primary">Матн</span>
                <br/>
                <span class="small text-muted">Шикоят ё пешниҳодро ба таври васеъ ё мухтасар, то қадри имкон аниқ баён намоед.<br/>
                Он метавонад якчанд мавзӯъҳои дилхоҳро дар бар гирад.</span>
            </label>
            <div class="col-md-9">
                <textarea name="pgCplContent" id="pgCplContent" cols="" rows="10" class="frm-control" onkeyup="pgOnchange(this.id,this.value);"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label $$ frm-control-label" for="pgName">
                <span class="text-warning">Муҳим</span>
                <br/>
                <span class="small text-muted">Ҳангоми фиристодан номи Шумо сабт намешавад, яъне пинҳонӣ равона карда мешавад. <br/>
                    Шикоят ё пешниҳоди фиристодаи Шумо барои беҳтар кардани системаи имтиҳоноти донишкада истифода бурда мешавад.<br/></span>
            </label>
            <div class="col-md-9">
                <p class="small">
                    Бо фиристодани мактуб Шумо розигии худро барои истифодаи матн ё мазмуни он тасдиқ менамоед.
                    Агар матн фикрҳо ё идеяҳое дошта бошад, ки Шумо онро додан/паҳн кардан намехоҳед ва ё намехоҳед,
                    ки он бе розигии Шумо кор бурда шавад, <span class="text-warning">он гоҳ онро: нафиристед</span>.
                </p>
                <button id="pgCplSubmit" name="" type="submit" class="btn btn-primary btn-sm"  onclick="pgCplSubmit_onClick();">Фиристодан</button>
                <script type="text/javascript">
                    pgCplSubmit.type="button";
                    var pattern = /(pgCpl[A-z]*?)=(.*?);/g;
                    var text = document.cookie;
                    var result;
                    while((result = pattern.exec(text)) != null) {
                        document.getElementById(result[1]).value=result[2].replace(/<br>/g,'\n');
                    }
                    function pgOnchange(id,value){
                        document.cookie=id+"="+value.replace(/\n/g,'<br>')+";"+"max-age="+300+";";
                    }
                    function pgCplSubmit_onClick(){
                        if(pgCplContent.value.length<20){
                            alert('Матн набояд холи бошад');
                        }
                        else{
                            document.cookie="pgCplCaption=;max-age=0;";
                            document.cookie="pgCplContent=;max-age=0;";
                            pgLetter.submit();
                        }
                    }
                </script>
            </div>
        </div>
        <br/>
        <br/>
    </form>
</div>
</body>
<?php include app::templateLink("page/_footer");?>
</html>