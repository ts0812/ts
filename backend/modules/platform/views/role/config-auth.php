<?php

/* @var $this yii\web\View */

$this->title = "分配权限";
?>
    <style>
        * , .dn-ckx-plugin > .dn-row-ckx{
            list-style: none;
        }

        .dn-level-li > label{
            position:relative;
            cursor: pointer;
            padding-left: 25px;
        }
        .dn-level-li [type=checkbox]{
            display:none;
            height:auto;
        }
        .ui-ckx{
            background: url("/img/download.png");
            background-repeat: no-repeat;
            width:24px;
            height: 24px;
            position: absolute;
            left:0;
            top:-2px;
            display: inline-block;
        }
        .ui-ckx.hover{
            background-position-x:-24px;
        }
        .ui-ckx.active-path{
            background-position-x:-48px;
        }
        .ui-ckx.active{
            background-position-x:-72px;
        }
        .dn-row-ckx{
            padding-left: 20px;
            margin-left: 20px;
        }
        .dn-row-ckx > .dn-level-li .ui-ckx.disabled{
            background-position-x:-120px;
            cursor: no-drop;
        }
        .dn-level-li{
            padding-top: 4px;
            padding-bottom: 4px;
        }
        .dn-level-li > span.dn-ckx-icon{
            width:20px;
            height:20px;
            cursor:pointer;
            float:left;
            background-image: url("/img/download.png");
            background-position-x: 39px ;
            background-position-y: -3px;
        }
        .dn-level-li > span.dn-ckx-icon.actived{
            background-position-x:right ;
        }
        /*horizontal*/
        .vertical * , .horizontal *{
            padding:0px;
            margin:0px;
            list-style: none;
        }
        .horizontal{
            overflow:hidden;
            position:relative;
            border:thin solid #ddd;
            border-left:none;
        }
        .horizontal .dn-row-ckx{
            padding-left: 0px;
        }
        .horizontal .dn-row-ckx{
            border-left:thin solid #ddd;
            position:relative;
            top:0%;
            left:0%;
        }
        .horizontal  span.dn-ckx-icon{
            display:none;
        }
        .horizontal > .dn-row-ckx{
            width:100%;
            position:static;
        }
        .horizontal .dn-level-li{
            position:relative;
            padding-top:5.5px;
            padding-bottom: 5.5px;
            margin-top:-5px;
            margin-bottom: -5px;
            border-top:thin solid #ddd;
            border-bottom:thin solid rgba(0, 0, 0, 0);
        }
        .horizontal .dn-level-li:nth-child(odd){
            border-top:none;
        }
        .horizontal .dn-level-li label{
            top:50%;
            margin-left: 5px;
            margin-top: -10.5px;
        }
        /*vertical*/
        .vertical .dn-row-ckx{
            padding-top:10px;
            overflow: hidden;
        }
        .vertical > .dn-row-ckx{
            border-left: thin solid #ddd;
            padding:0px;
        }
        .vertical .dn-row-ckx{
            padding-left: 0px;
        }
        .vertical  span.dn-ckx-icon{
            display:none;
        }
        .vertical >  .dn-row-ckx > .dn-level-li:first-child{
            /*padding-bottom: 10px;*/
            border-bottom: thin solid #ddd;
        }
        .vertical .dn-row-ckx .dn-level-li{
            position:relative;
            float: left;
            min-height: 35px;
            padding-top:10px;
            border-right: thin solid #ddd;
            margin-left: -1px;
            text-align: center;
            word-wrap:break-word ;
            border-top: thin solid #ddd;
        }
        .vertical .dn-row-ckx .dn-level-li:nth-child(even){
            border-right: none;
        }</style>
    <style>
        body{
            background:white;
        }
        .ibox{
            padding:15px;
        }
        h4{
            color:white;
            padding:15px;
            padding-left:25px;
            background:#1ab394;
            margin-top: 45px;
            margin-bottom: 10px;
            margin-left: -25px;
            margin-right: -25px;
        }
        small{
            color:#999;
        }
        .description li{
            margin-bottom: 10px;
        }
        ul{
            padding: 8px;
        }
        ul ul {
            padding: 8px;
            background-color: #eef5fa;
        }
        ul ul ul {
            padding: 8px;
            background-color: #f5faff;
        }
        ul ul ul ul{
            padding: 8px;
            background-color: #fafaff;
        }
        ul ul ul ul ul{
            padding: 8px;
            background-color: #ffffff;
        }
        ul ul ul ul ul ul{
            padding: 8px;
            background-color: #fbf0ff;
        }
        ul ul ul ul ul ul ul{
            padding: 8px;
            background-color: #fbf0ff;
        }
    </style>
    <body>
    <div class="ibox">
        <form class="dn-ckx-plugin container-fluid" action="config-auth?id=<?= Yii::$app->request->get("id") ?>" method="post">
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <ul class="dn-row-ckx">
                <li class="dn-level-li" id="treeview" >
                    <!-- <span class="dn-ckx-icon"></span> -->
                    <label>
                        <span class="ui-ckx">

                        </span>
                        <input type="checkbox"/>
                         选中全部
                    </label>
                </li>
            </ul>
            <div class="form-group">
                <button type="submit" class="btn" style="color:#ffffff;background: #3faa0f;">保存</button>
            </div>
        </form>
    </div>
    <script>
        var nodes = <?=json_encode($list) ?>;
        var node_ids = <?=json_encode($mcIds) ?>;
    </script>
<?php
$this->registerJs('
    changeCheckState(nodes , 0 , 1);
    function changeCheckState(nodes , pid , level){
        for(var i = 0; i < nodes.length; i++){
            var node = nodes[i];
            var node_id = node.node_id;
            var node_name = node.name;
            var index = node_ids[node_id];
            var calss = "";
            var checked = "";
            if (index !== undefined){
                calss = "active";
                checked = "checked=\'checked\'";
            }

            var html = \'<ul class="dn-row-ckx level-\' + level + \'"><li class="dn-level-li"  id="node_id_\'+node_id+\'"  ><label><span class="ui-ckx \' + calss + \'"></span><input name="mcIds[]" type="checkbox" \' + checked + \' value="\'+node_id+\'" />\' + node_name +\'</label></li></ul>\';

            if(pid === 0){
                $("#treeview").append(html);
                if(node.z !== undefined){
                    changeCheckState(node.z , node_id ,2);
                }
            }else {
                $("#node_id_" + pid).append(html);
                if(node.z !== undefined){
                    changeCheckState(node.z , node_id ,3);
                }
            }
        }
    }
$(function () {
    $(".dn-ckx-plugin").each(function() {
        var $this = $(this);
        //水平
        if($this.hasClass("horizontal")){
            var Arr = [];
            $this.find(".dn-row-ckx").each( function(i,e){
                var Num = parseInt($(e).attr("data-level")) || -1;
                Arr.push(Num);
            })
            var Max         = Math.max.apply(null, Arr) ,
                eachULWid   = ( 10 / (Max+1) )*10 + "%" ;
            $this.find(".dn-row-ckx").css("left",eachULWid);
        };

        var obj = {
            ckx      : $this.find(":checkbox , .ui-ckx").not(":disabled") ,
            li       : $this.find(".dn-level-li") ,
            ckxIcon  : $("span.ui-ckx")
        }
        var tree = $(this).not(".horizontal,.vertical");
        if(tree){
            var li = tree.find(".dn-level-li");
            li.each(function(index, el) {
                if(!$(el).find(".dn-row-ckx").length>0){
                    $(el).children(".dn-ckx-icon").css({"backgroundPositionX":58});
                }
            })
        }
        obj.li.find(":checkbox:disabled").prev(".ui-ckx").addClass("disabled");
        obj.li.on("click", function(event) {
            
            if(event.target.tagName === "LABEL") return ;
            if(event.target.checked){
                $(event.currentTarget).children("label").find(obj.ckx).prop("checked",true).prev(".ui-ckx").addClass("active");
            }else{
                //这个判断用于防止兄弟被选中的情况下还冒泡上级取消被选
                if($(event.currentTarget).children(".dn-row-ckx").find(":checked").length<=0){
                    // $(event.currentTarget).children("label").find(obj.ckx).prop("checked",false).prev(".ui-ckx").removeClass("active");
                }
            }
        })
        $this.find(".dn-ckx-icon").on("click", function(event) {
            event.stopPropagation();
            var ul = $(this).siblings(".dn-row-ckx");
            if(ul.length > 0){
                ul.slideToggle();
                $(this).toggleClass("actived");
            };
        });
        obj.ckx.on("click", function(event) {
            if(event.target.checked == undefined){
                //$(event.target).closest(obj.li).find(obj.ckx).prop("checked",false).prev(".ui-ckx").removeClass("active");
                $(event.target).closest(obj.li).find(obj.ckx).prop("checked",true).prev(".ui-ckx").addClass("active");
            }else {
                if(event.target.checked == false){
                    $(event.target).closest(obj.li).find(obj.ckx).prop("checked",true).prev(".ui-ckx").addClass("active");
                }else{
                    $(event.target).closest(obj.li).find(obj.ckx).prop("checked",false).prev(".ui-ckx").removeClass("active");
                }
            }
        });
        obj.li.children("label").hover(function() {
            $(this).children(".ui-ckx").addClass("hover");
        }, function() {
            $(this).children(".ui-ckx").removeClass("hover");
        });
    });});
', \yii\web\View::POS_END);