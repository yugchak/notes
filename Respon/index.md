## 响应式网页



**CSS的@media规则**

```
/*通用样式*/
*{
	margin:0;padding:0;text-decoration:none;list-style:none;
	font-size:14px;font-family:"微软雅黑";text-align:center;
	color:#fff;
}
.clear{
	clear:both;
}
#header,#content,#footer{
	margin:0 auto;margin-top:10px;
}  
#header,#footer{
	margin-top:10px;height:100px;
}
#header,#footer,.left,.right,.center{
	background:#333;
}

/*手机*/
@media screen and (max-width:600px){
	#header,#content,#footer{
		width:400px;}
	.right,.center{
		margin-top:10px;}
	.left,.right{
		height:100px;}
	.center{
		height:200px;}
}

/*平板*/
@media screen and (min-width:600px) and (max-width:960px){
	#header,#content,#footer{
		width:600px;}
	.right{
		display:none;}
	.left,.center{
		height:400px;float:left;}
	.left{
		width:160px;margin-right:10px;}
	.center{
		width:430px;}
}

/*PC*/
@media screen and (min-width:960px){
	#header,#content,#footer{
		width:960px;}
	.left,.center,.right{
		height:400px;float:left;}
	.left{
		width:200px;margin-right:10px;}
	.center{
		width:540px;margin-right:10px;}
	.right{
		width:200px;} 
}
```



**选择加载CSS**

```
<link rel="stylesheet" type="text/css"
media="screen and (max-device-width: 400px)"
href="tinyScreen.css" />
```

如果屏幕宽度小于400像素（max-device-width: 400px），就加载tinyScreen.css文件

```
<link rel="stylesheet" type="text/css"
media="screen and (min-width: 400px) and (max-device-width: 600px)"
href="smallScreen.css" />
```

如果屏幕宽度在400像素到600像素之间，则加载smallScreen.css文件。