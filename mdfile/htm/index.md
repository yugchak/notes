<head>
	<script type="text/javascript">
	(function() {
		var link = document.createElement('link');
		link.type = 'image/x-icon';
		link.rel = 'shortcut icon';
		link.href = '../h.ico';
		document.getElementsByTagName('head')[0].appendChild(link);
	}());
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>


- [锚点](#锚点)
	- [同一页面跳转](#同一页面跳转)
	- [不同页面跳转](#不同页面跳转)
	- [触发js事件跳转](#触发js事件跳转)
- [响应式网页](#响应式网页)
	- [CSS的@media规则](#CSS的@media规则)
	- [选择加载CSS](#选择加载CSS)



## 锚点



#### **同一页面跳转**

```
<a name="add"></a> 或者 <p id="add"></p> （ps：用id兼容性好些）
<a href="#add">跳转到add</a>
<a href="#">返回页面顶部</a>
```

#### **不同页面跳转**

```
在不同页面中，锚点定位在a.html中，从另外一个页面的链接跳转到这个锚点
<a href="a.html#add">跳转到a.add</a>
```

#### **触发js事件跳转**

第一种：

```
<a href="#add" onclick="add()">触发add函数并跳转到add锚点</a>
```

第二种：

```
<p id="pNode"></p> 
<a href="#" onclick="document.getElemetnById('pNode').scrollIntoView(true);return false;">通过scrollIntoView实现锚点效果</a>
```

> scrollIntoView()的用法
>  **scrollIntoView**是一个与页面（容器）滚动相关的API（[官方解释](https://drafts.csswg.org/cssom-view/#dom-element-scrollintoview)），该API只有boolean类型的参数能得到良好的支持（firefox 36+都支持），所以在这里只讨论参数Boolean类型的情况
>  调用方法为 element.scrollIntoView() 参数默认为true。
>
> 参数为true时调用该函数，页面（或容器）发生滚动，使element的顶部与视图（容器）顶部对齐；
>
> 参数为false时，使element的底部与视图（容器）底部对齐。
>
> TIPS：页面（容器）可滚动时才有用！



## 响应式网页



#### **CSS的@media规则**

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



------



#### **选择加载CSS**

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


<div id="toTop">
  <a href="#" class="ryi-angle-up"></a>
</div>