$(function(){
	$('.btn-index-leaveMessage').click(function(){
		var name=$('input[name=name]').val();
		var content=$('#leave_content').val();
		if(checkStr(name) && checkStr(content)){
			$.post("/",{name:name,content:content},function(el){
				layer.msg(el,{time:2000},function(){
					window.location.reload();
				});
			});
		}	
	})
	//正则匹配
	function checkStr(str){
		if(str==''){
			layer.msg('留言不能为空',{time:3000,icon:0});return false;
		}
		var reg=/^[0-9a-zA-Z\u4e00-\u9fa5 ]{1,20}$/;
		var res=str.match(reg);
		if(res==null){
			layer.msg(str+'含有非法字符',{time:3000,icon:0});return false;
		}
		return true;
	}
})