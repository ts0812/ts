<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use yii\helpers\Url;
$this->title = "分配权限";
?>
<body>
    <div class="ibox">
        <form class="dn-ckx-plugin container-fluid" action="<?= Url::to(['/platform/role/auth', 'id' =>(int)Yii::$app->request->get('id')]) ?>" method="post">
            <input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
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
                <button type="submit" class="btn" style="color:#ffffff;">保存</button>
            </div>
        </form>
    </div>
    <script>
        var nodes = <?= json_encode($list) ?>;
        console.log(nodes);
        var node_ids = <?= json_encode($auth_id) ?>;
        console.log(node_ids);
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

            if(level === 1){
                var html = \'<ul class="dn-row-ckx level-\' + level + \'"><li class="dn-level-li"  id="node_id_\'+node_id+\'"  ><label>\' + node_name +\'</label></li></ul>\';
            }else{
                var html = \'<ul class="dn-row-ckx level-\' + level + \'"><li class="dn-level-li"  id="node_id_\'+node_id+\'"  ><label><span class="ui-ckx \' + calss + \'"></span><input name="auth[]" type="checkbox" \' + checked + \' value="\'+node_id+\'" />\' + node_name +\'</label></li></ul>\';
            }




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
            console.log(event);
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
    