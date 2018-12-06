<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/upload.css">
    <title>上传作品</title>
</head>
<body>
<a id="zwb_upload">
    <input type="file" class="add" multiple>点击上传文件
</a>
<input type="text" name="filePath" id="callbackPath2">
<script src="public/js/jquery.min.js"></script>
<script src="public/js/upload.min.js"></script>
<script>
    //配置需要引入jq 1.7.2版本以上
    //服务器端成功返回 {state:1,path:文件保存路径}
    //服务器端失败返回 {state:0,errmsg:错误原因}
    //默认做了文件名不能含有中文,后端接收文件的变量名为file
    $("#zwb_upload").bindUpload({
        url:"/upload.php",//上传服务器地址
        callbackPath:"#callbackPath2",//绑定上传成功后 图片地址的保存容器的id或者class 必须为input或者textarea等可以使用$(..).val()设置之的表单元素
        // ps:值返回上传成功的 默认id为#callbackPath  保存容器为位置不限制,id需要加上#号,class需要加上.
        // 返回格式为:
        // 原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径....
        num:10,//上传数量的限制 默认为空 无限制
        type:"jpg|png|gif|svg|jpeg",//上传文件类型 默认为空 无限制
        size:3,//上传文件大小的限制,默认为5单位默认为mb
    });
</script>
</body>
</html>