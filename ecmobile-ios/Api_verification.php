<?php
	
$data = getData('./ecmobile.json');

function getData($file)
{
	$text = file_get_contents($file);
	$text = preg_replace("%//\s+[^\n]+%", '', $text);
	$data = json_decode($text, true);
	if (empty($data)) {
		return false;
	} else {
		return formatData($data);
	}
}

function formatData($data)
{
	$return = array();
	foreach ($data['controller'] as $key => $value) {
		$api = array_filter(explode(' ', $key));
		$temp = array('type'=>$api[0], 'url'=>trim(end($api)), 'request'=>$value['request']);
		$return['api'][] = $temp;
	}
	
	$return['server'] = $data['server'];
	$return['model'] = $data['model'];
	
	return $return;
}
?>
<html>
<head>
	<meta charset="utf-8">
	<link href="index.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
</head>
<body>
	<div id="api_list">
		<?php $i = 1 ?>
		<?php foreach ($data['api'] as $key => $value): ?>
		<div style="border: #3f3 1px solid;margin-bottom:5px;padding:5px;border-radius:4px;" class="par">

			<p><?php echo $value['url'] ?><input type="hidden" value="<?php echo $value['url'] ?>"></p>
			<button  <?php if ($value['url'] == 'user/signin') {
				echo 'class="btn signin"';
			} else {
				echo 'class="btn ver_btn"';
			} ?> id="<?php echo $i ?>">发送</button>

			<div id='parms_<?php echo $i ?>' style="display:block;" class="parms"><form action="<?php echo $key ?>">
				<table border="1">

				<?php foreach ($value['request'] as $ke => $val): ?><?php 
					if (is_string($val) && strpos($val, '{') !== false && strpos($val, '}') !== false)
					{
						$letters = array('{', '}');
						$fruit   = array(' ', ' ');
						$model  = strtoupper(trim(str_replace($letters, $fruit, $val)));
						if (isset($data['model'][$model])) {
							echo '<tr><td>'.$model."</td><td>";
							foreach ($data['model'][$model] as $k => $v) {
								echo trim(str_replace('!', '',$k)).':<input type="text" name="'.trim(str_replace('!', '',$k)).'" value="'.$v.'" >';
							}
							echo '</td></tr>';
						}
					} else {
						if (is_array($val)) {
							$val = implode(',', $val);
						}
						echo '<tr><td>'.trim(str_replace('!', '',$ke)).'</td><td><input type="text" name="'.trim(str_replace('!', '',$ke)).'" value="'.$val.'" ></td></tr>';
					}
				?><?php endforeach ?>

				</table>
			</form></div>

			</div>
			<?php $i++ ?>
		<?php endforeach ?>
	</div>

	<div id="api_url">
		<input type="hidden" value="<?php echo $data['server']['development'] ?>">
		<?php echo $data['server']['development'] ?>
	</div>

	<div class="parms_div">
		<span>请求返回：</span>
		<textarea id="request" style="width:500px;height:500px;">
		
		</textarea>
	</div>
	<?php $queue = '<script type="text/javascript" charset="utf-8">$(document).ready(function(){' ?>
	<?php $queue .= 'var arr_q = []' ?>
	<?php foreach ($data['api'] as $key => $value): ?>
	<?php 
		$cc = str_replace('/', '_', $value['url']);
		$queue .= '; var '.$cc.' = function(){';

		$queue .= '};
		';
		$queue .= 'arr_q.push('+$cc+');';
	?>
	<?php endforeach ?>
	<?php $queue .= '});</script>' ?>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){ 

		$('input[name=type]').val('');
		$('input[name=field]').val('');
		$('input[name=sort_by]').val('');

		$("#apipick").change(function(){
			$("#request").val('');
			var api = $(this).val();
			if (api == '') {
				return false;
			}
			$(".parms").hide();
			var index = $("#apipick :selected").index();
			$("#"+index).show();
		});

		$('button.btn').click(function(){
			var me = $(this);
			var parmsId = 'parms_'+me.attr('id');;
			var url;
			var a = me.prev('p').children('input[type=hidden]').val(); 
			var b = $("#api_url input[type=hidden]").val();
			var parm = {};

			$("#"+parmsId+" tr").each(function(){
			    if($(this).find('input').length > 1){
			        name = $(this).find('td:first').text();
			        name = name.toLowerCase();
			        parm[name] = {};
			        $(this).find('input').each(function(){
			            var n = $(this).attr('name');
			            parm[name][n] = $(this).val();
			        });
			    } else {
				   var input = $(this).find('input');
			       var name = input.attr('name');
				   parm[name] = input.val();
			    };
			});

			url = b+a;

			$.ajax({

				'url': url,
				'data':{'json': JSON.stringify(parm)},
				'dataType': 'json',
				'type' : 'post',
				'success':function(data){
					if (data.status.succeed == 1) {
						if (data.data.session !== undefined) {
							$('input[name=sid]').val(data.data.session.sid);
							$('input[name=uid]').val(data.data.session.uid);
						} 
					}
					$("#request").val(JsonUti.convertToString(data));
				},
				'beforeSend' : function(){
					$("#request").val('加载数据中...');
				},
				'error' : function(i, data){
					$("#request").val(i.responseText);
				}
			});

		});

		$("button.ver_btn").click(function(){
			var me = $(this);
			var parmsId = 'parms_'+me.attr('id');;
			var url;
			var a = me.prev('p').children('input[type=hidden]').val(); 
			var b = $("#api_url input[type=hidden]").val();
			var parm = {};

			$("#"+parmsId+" tr").each(function(){
			    if($(this).find('input').length > 1){
			        name = $(this).find('td:first').text();
			        name = name.toLowerCase();
			        parm[name] = {};
			        $(this).find('input').each(function(){
			            var n = $(this).attr('name');
			            parm[name][n] = $(this).val();
			        });
			    } else {
				   var input = $(this).find('input');
			       var name = input.attr('name');
				   parm[name] = input.val();
			    };
			});

			url = b+a;

			$.ajax({

				'url': url,
				'data':{'json': JSON.stringify(parm)},
				'dataType': 'json',
				'type' : 'post',
				'success':function(data){
					if (data.status.succeed == 1) {
						var fun_name = me.prev('p').text();
						me.parents('div.par').html(fun_name+'接口正常');
					}
				},
				'beforeSend' : function(){
					$("#request").val('加载数据中...');
				},
				'error' : function(i, data){
					$("#request").val(i.responseText);
				}
			});
		});
	

		$("button.signin").click();
		$("button.ver_btn").each(function(){
			$(this).click();
		});


	});
	
	
	
	
	
	
	var JsonUti = {

	            //定义换行符

	            n: "\n",

	            //定义制表符

	            t: "\t",

	            //转换String

	            convertToString: function (obj) {

	                return JsonUti.__writeObj(obj, 1);

	            },

	            //写对象

	            __writeObj: function (obj    //对象

	                    , level             //层次（基数为1）

	                    , isInArray) {       //此对象是否在一个集合内

	                //如果为空，直接输出null

	                if (obj == null) {

	                    return "null";

	                }

	                //为普通类型，直接输出值

	                if (obj.constructor == Number || obj.constructor == Date || obj.constructor == String || obj.constructor == Boolean) {

	                    var v = obj.toString();

	                    var tab = isInArray ? JsonUti.__repeatStr(JsonUti.t, level - 1) : "";

	                    if (obj.constructor == String || obj.constructor == Date) {

	                        //时间格式化只是单纯输出字符串，而不是Date对象

	                        return tab + ("\"" + v + "\"");

	                    }

	                    else if (obj.constructor == Boolean) {

	                        return tab + v.toLowerCase();

	                    }

	                    else {

	                        return tab + (v);

	                    }

	                }



	                //写Json对象，缓存字符串

	                var currentObjStrings = [];

	                //遍历属性

	                for (var name in obj) {

	                    var temp = [];

	                    //格式化Tab

	                    var paddingTab = JsonUti.__repeatStr(JsonUti.t, level);

	                    temp.push(paddingTab);

	                    //写出属性名

	                    temp.push(name + " : ");



	                    var val = obj[name];

	                    if (val == null) {

	                        temp.push("null");

	                    }

	                    else {

	                        var c = val.constructor;



	                        if (c == Array) { //如果为集合，循环内部对象

	                            temp.push(JsonUti.n + paddingTab + "[" + JsonUti.n);

	                            var levelUp = level + 2;    //层级+2



	                            var tempArrValue = [];      //集合元素相关字符串缓存片段

	                            for (var i = 0; i < val.length; i++) {

	                                //递归写对象                         

	                                tempArrValue.push(JsonUti.__writeObj(val[i], levelUp, true));

	                            }



	                            temp.push(tempArrValue.join("," + JsonUti.n));

	                            temp.push(JsonUti.n + paddingTab + "]");

	                        }

	                        else if (c == Function) {

	                            temp.push("[Function]");

	                        }

	                        else {

	                            //递归写对象

	                            temp.push(JsonUti.__writeObj(val, level + 1));

	                        }

	                    }

	                    //加入当前对象“属性”字符串

	                    currentObjStrings.push(temp.join(""));

	                }

	                return (level > 1 && !isInArray ? JsonUti.n : "")                       //如果Json对象是内部，就要换行格式化

	                    + JsonUti.__repeatStr(JsonUti.t, level - 1) + "{" + JsonUti.n     //加层次Tab格式化

	                    + currentObjStrings.join("," + JsonUti.n)                       //串联所有属性值

	                    + JsonUti.n + JsonUti.__repeatStr(JsonUti.t, level - 1) + "}";   //封闭对象

	            },

	            __isArray: function (obj) {

	                if (obj) {

	                    return obj.constructor == Array;

	                }

	                return false;

	            },

	            __repeatStr: function (str, times) {

	                var newStr = [];

	                if (times > 0) {

	                    for (var i = 0; i < times; i++) {

	                        newStr.push(str);

	                    }

	                }

	                return newStr.join("");

	            }

	        };
	</script>

	<?php echo $queue ?>

</body>
</html>


